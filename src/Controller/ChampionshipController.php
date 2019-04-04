<?php


namespace App\Controller;


use App\Entity\Championship;
use App\Entity\Group;
use App\Entity\SpecificationPoint;
use App\Form\ChampionshipEditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChampionshipController extends AbstractController
{
    /**
     * @Route("/championship", name="championships_list");
     */
    public function listChampionships(): Response
    {
        $championships = $this->getDoctrine()->getRepository(Championship::class)->findAll();

        return $this->render('championship/championship-list.html.twig', [
            "championships" => $championships,
            "areChampionships" => ( count($championships) > 0 )
        ]);
    }

    /**
     * @Route("/championship/edit", name="championship_edit");
     */
    public function editChampionship(Request $request): Response
    {
        $championshipId = (int) $request->get("championshipId" );
        $championshipName = $request->get("championshipName" );

        if( $request->getMethod() === "POST" ){

            $championship = $this->getDoctrine()->getRepository(Championship::class)->find( $championshipId );

            if( $championship !== null ){
                $championship->changeName( $championshipName );
            }
            else{
                $specificationPoint = new SpecificationPoint(3,0,-1,1);
                $championship = new Championship($championshipName, false, $specificationPoint);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist( $championship );
            $entityManager->flush();

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
    public function pageChampionship(int $championshipId, Request $request): Response
    {
        $championship = $this->getDoctrine()->getRepository(Championship::class)->find( $championshipId );

        if( $championship === null ){
            return $this->redirectToRoute("championships_list");
        }

        if( $request->getMethod() === "POST" ){
            $championship->start();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist( $championship );
            $entityManager->flush();
        }

        return $this->render('championship/championship-page.html.twig', [
            "championship" => $championship
        ]);
    }

    /**
     * @Route("/championship/{championshipId}/groups", name="championship_group")
     */
    public function pageChampionshipGroups(int $championshipId, Request $request): Response
    {
        $championship = $this->getDoctrine()->getRepository(Championship::class)->find( $championshipId );
        $groupName = "";

        if( $championship == null ){
            return $this->redirectToRoute("championships_list");
        }

        if( $request->getMethod() == "POST" ){
            $groupName = $request->get("groupName");

            $group = new Group( $groupName, $championship );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist( $group );
            $entityManager->flush();
        }

        return $this->render('championship/championship-edit-group.html.twig', [
            "championship" => $championship,
            "groupName" => $groupName
        ]);
    }

    /**
     * @Route("/championship/{championshipId}/groups/composition", name="championship_group_composition")
     */
    public function pageChampionshipGroupsComposition(int $championshipId, Request $request): Response
    {
        $selectedClubId = (int) $request->get("club", 0);
        $selectedGroupId = (int) $request->get("group", 0);

        $championship = $this->getDoctrine()->getRepository(Championship::class)->find( $championshipId );

        if( $championship == null ){
            return $this->redirectToRoute("championships_list");
        }

        $clubs = [];
        $teams = [];
        $groups = [];

        return $this->render('championship/championship-edit-group-composition.html.twig', [
            "championship" => $championship,
            "selectedClub" => $selectedClubId,
            "clubs" => $clubs,
            "teams" => $teams,
            "selectedGroup" => $selectedGroupId,
            "groups" => $championship->getGroups()
        ]);
    }
}