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

        if ($req->isMethod('GET')) {


            return $this->render('match/match.form.html.twig',[], new Response(200));
        }

        if($req->isMethod("POST")){


            //TODO : remplacer par la liste des ParticipatingTeam correspondant
            $teams = $this->getDoctrine()
                ->getRepository(Team::class)
                ->findAll();
            $countMatch = count($teams);
            $matchListHome = [];
            $matchListAway = [];

            foreach ($teams as $team){

               for($i=0; $i<$countMatch; $i++){
                   $matchNameHome = $team->getName() . " - " .$teams[$i]->getName();
                   $matchNameAway = $teams[$i]->getName() . " - " . $team->getName();
                   if($team != $teams[$i]){
                       if(! in_array($matchNameAway,$matchListHome)){
                           $matchListHome[] = $matchNameHome;
                       }else{
                           $matchListAway[] = $matchNameHome;
                       }
                   }

               }

            }
            return $this ->render('match/match.list.html.twig',[
                "matchListHome" => $matchListHome,
                "matchListAway" => $matchListAway
                ],new Response(200));

        }

        return null;
    }
}