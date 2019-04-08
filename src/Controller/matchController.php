<?php
/**
 * Created by PhpStorm.
 * User: Mickael
 * Date: 05/04/2019
 * Time: 09:46
 */

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Team;
use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class matchController extends AbstractController
{
    /**
     * @Route("/match/generate", name="match-generate")
     */
    public function generateMatch(Request $req) {
        $entityManager = $this->getDoctrine()->getManager();

        if ($req->isMethod('GET')) {


            return $this->render('match/match.form.html.twig',[], new Response(200));
        }

        if($req->isMethod("POST")){


            //TODO : remplacer par la liste des ParticipatingTeam correspondant
            $teams = $this->getDoctrine()
                ->getRepository(Team::class)
                ->findAll();
            $countMatch = count($teams);
            $matchListHomePair = [];
            $matchListAwayPair = [];
            $matchListHomeString = [];
            $matchListAwayString = [];

            foreach ($teams as $team){

               for($i=0; $i<$countMatch; $i++){
                   $matchPairAway = $teams[$i]->getId() . " - " . $team->getId();

                   if($team != $teams[$i]){
                       if(! in_array($matchPairAway,$matchListHomePair)){
                           $match = new Game($team,$teams[$i],1);
                           $matchListHomePair[] = $team->getId() . " - " . $teams[$i]->getId();
                           $matchListHomeString[] = $match -> getHomeTeam()->getName() . " - " . $match-> getOutsideTeam()->getName();
                       }else{
                           $match = new Game($team,$teams[$i],0);
                           $matchListAwayPair[] = $team->getId() . " - " . $teams[$i]->getId();
                           $matchListAwayString[] = $match -> getHomeTeam()->getName() . " - " . $match-> getOutsideTeam()->getName();
                       }
                       $entityManager->persist($match);

                   }

               }
                $entityManager->flush();

            }
            return $this ->render('match/match.list.html.twig',[
                "matchListHome" => $matchListHomeString,
                "matchListAway" => $matchListAwayString
                ],new Response(200));

        }

        return null;
    }
}