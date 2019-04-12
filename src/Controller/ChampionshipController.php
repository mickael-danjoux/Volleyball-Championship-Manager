<?php


namespace App\Controller;


use App\Entity\Championship;
use App\Entity\ChampionshipTeam;
use App\Entity\Club;
use App\Entity\Game;
use App\Entity\Pool;
use App\Entity\SpecificationPoint;
use App\Entity\Team;
use App\Exception\ChampionshipNotFound;
use App\Exception\PoolNotFound;
use App\Form\ChampionshipEditType;
use App\Repository\ChampionshipRepository;
use App\Repository\PoolRepository;
use App\Utility\TeamPairGenerator;
use Doctrine\ORM\EntityNotFoundException;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChampionshipController extends AbstractController
{
    /**
     * @Route("/championship", name="championships_list");
     */
    public function listChampionships(ChampionshipRepository $championshipRepository): Response
    {
        $championships = $championshipRepository->getAll();

        return $this->render('championship/list.html.twig', [
            "championships" => $championships
        ]);
    }

    /**
     * @Route("/championship/edit", name="championship_edit");
     */
    public function editChampionship(Request $request, ChampionshipRepository $championshipRepository): Response
    {
        $championshipId = (int) $request->get("championshipId" );
        $championshipName = $request->get("championshipName" );

        if( $request->getMethod() === "POST" ){

            try{
                $championship = $championshipRepository->get( $championshipId );
                $championship->changeName( $championshipName );
            }
            catch(ChampionshipNotFound $exception){
                $specificationPoint = new SpecificationPoint(3,0,-1,1);
                $championship = new Championship($championshipName, false, $specificationPoint);
            }

            $championshipRepository->save( $championship );

            return $this->redirectToRoute('championships_list');
        }

        return $this->render('championship/championship-edit.html.twig', [
            "championshipId" => $championshipId,
            "championshipName" => $championshipName
        ]);
    }

    /**
     * @Route("/championship/{championshipId}", name="championship_page")
     */
    public function pageChampionship(int $championshipId, Request $request, ChampionshipRepository $championshipRepository): Response
    {
        try{
            $championship = $championshipRepository->get( $championshipId );
        }
        catch(ChampionshipNotFound $exception){
            return $this->redirectToRoute("championships_list");
        }

        if( $request->getMethod() === "POST" ){

            $championship->start();
            $championshipRepository->save( $championship );
        }

        return $this->render('championship/championship-page.html.twig', [
            "championship" => $championship
        ]);
    }

    /**
     * @Route("/championship/{championshipId}/pools", name="championship_pool")
     */
    public function pageChampionshipGroups(int $championshipId, Request $request, ChampionshipRepository $championshipRepository, PoolRepository$poolRepository): Response
    {
        try{
            $championship = $championshipRepository->get( $championshipId );
        }
        catch(ChampionshipNotFound $exception){
            return $this->redirectToRoute("championships_list");
        }

        $poolName = "";

        if( $request->getMethod() == "POST" ){
            $poolName = $request->get("poolName");

            $pool = new Pool( $poolName, $championship );

            $poolRepository->save( $pool );

            return $this->redirectToRoute('championship_pool', [
                "championshipId" => $championship->getId()
            ]);
        }

        return $this->render('championship/championship-edit-pool.html.twig', [
            "championship" => $championship,
            "poolName" => $poolName
        ]);
    }

    /**
     * @Route("/championship/{championshipId}/pools/composition", name="championship_pool_composition")
     */
    public function pageChampionshipGroupsComposition(int $championshipId, Request $request, ChampionshipRepository $championshipRepository, PoolRepository $poolRepository): Response
    {
        try{
            $championship = $championshipRepository->get( $championshipId );
        }
        catch(ChampionshipNotFound $exception){
            return $this->redirectToRoute("championships_list");
        }

        $selectedClubId = (int) $request->get("club", 0);
        $selectedPoolId = (int) $request->get("pool", 0);


        if( $selectedPoolId > 0 ){

            try{
                $pool = $poolRepository->get( $selectedPoolId );
            }
            catch(PoolNotFound $exception){
                throw $exception;
            }

        }
        else{
            $pool = $championship->getPools()[0];
        }

        $teams = [];
        if( $selectedClubId > 0 ){
            $club = $this->getDoctrine()->getRepository(Club::class)->find( $selectedClubId );

            if( $club !== null ){
                $teams = $this->getDoctrine()->getRepository(Team::class)->findBy(['club' => $club]);
            }
        }

        $clubs = $this->getDoctrine()->getRepository(Club::class)->findAll();

        if( $request->getMethod() === "POST" ){
            $teamId = $request->get('team');

            $team = $this->getDoctrine()->getRepository(Team::class)->find( $teamId );
            $pool->addChampionshipTeam( $team );

            $poolRepository->save( $pool );
        }


        return $this->render('championship/championship-edit-pool-composition.html.twig', [
            "championship" => $championship,
            "selectedClub" => $selectedClubId,
            "selectedPool" => $selectedPoolId,
            "clubs" => $clubs,
            "teams" => $teams,
            "pool" => $pool
        ]);
    }

    /**
     * @Route("/championship/{championshipId}/specification-point", name="championship_specification_point")
     */
    public function pageChampionshipSpecificationPoint(int $championshipId, Request $request, ChampionshipRepository $championshipRepository): Response
    {
        try{
            $championship = $championshipRepository->get( $championshipId );
        }
        catch( ChampionshipNotFound $exception ){
            return $this->redirectToRoute("championships_list");
        }

        $winPoint = $championship->getSpecificationPoint()->getWinPoint();
        $looseWBPoint = $championship->getSpecificationPoint()->getLooseWithBonusPoint();
        $loosePoint = $championship->getSpecificationPoint()->getLoosePoint();
        $forfeitPoint = $championship->getSpecificationPoint()->getForfeitPoint();

        if( $request->getMethod() === "POST" ){

            $winPoint = (int) $request->get('winPoint');
            $looseWBPoint = (int) $request->get('looseWBPoint');
            $loosePoint = (int) $request->get('loosePoint');
            $forfeitPoint = (int) $request->get('forfeitPoint');

            $specificationPoint = new SpecificationPoint($winPoint, $loosePoint, $forfeitPoint, $looseWBPoint);

            $championship->updateSpecificationPoint( $specificationPoint );
            $championshipRepository->save( $championship );
        }


        return $this->render('championship/championship-edit-specification-point.html.twig', [
            "championship" => $championship,
            "winPoint" => $winPoint,
            "looseWBPoint" => $looseWBPoint,
            "loosePoint" => $loosePoint,
            "forfeitPoint" => $forfeitPoint
        ]);
    }

    /**
     * @Route("/championship/{championshipId}/generate-calendar", name="championship_generate_calendar")
     */
    public function pageChampionshipGenerateCalendar(int $championshipId, Request $request, ChampionshipRepository $championshipRepository, PoolRepository $poolRepository): Response
    {
        try{
            $championship = $championshipRepository->get( $championshipId );
        }
        catch( ChampionshipNotFound $exception ){
            return $this->redirectToRoute("championships_list");
        }

        $selectedPoolId = (int) $request->get('pool');

        $pool = null;
        try{
            $pool = $poolRepository->get( $selectedPoolId );
        }
        catch(PoolNotFound $exception){
            $selectedPoolId = 0;
        }

        if( $request->getMethod() === "POST" ){
            $teams = $pool->getChampionshipTeams();

            $matchPair = new TeamPairGenerator($teams);
            $matchPair->generateTeamPair();

            $pool->reinitializeGames();
            $poolRepository->save( $pool );

            foreach( $matchPair->getTeamPairs() as $teamPair ){
                $game = new Game( $teamPair['home'], $teamPair['outside'], $teamPair['phase-one']  );
                $pool->addGame( $game );
            }

            $poolRepository->save( $pool );
        }

        return $this->render('championship/championship-edit-calendar.html.twig', [
            "championship" => $championship,
            "selectedPoolId" => $selectedPoolId,
            "pool" => $pool
        ]);
    }
}