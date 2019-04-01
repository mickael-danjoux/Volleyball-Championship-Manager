<?php

namespace App\Controller;

/**
 * Created by PhpStorm.
 * User: flore
 * Date: 01/04/2019
 * Time: 09:00
 */

namespace App\Controller;


use App\Entity\Club;
use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    /**
     * @Route("/club/team", name="club-team")
     */
    public function getTeams(Request $req) {

        if ($req->isMethod('GET')) {

            $clubId = $req->get("clubId");

            $club = $this->getDoctrine()
                ->getRepository(Club::class)
                ->find($clubId);

            $teams = $this->getDoctrine()
                ->getRepository(Team::class)
                ->findBy(array('club' => $club));

            return $this->render('team/team.list.html.twig', ['teams' => $teams, 'clubId' => $clubId], new Response(200));
        }

        return null;
    }

    /**
     * @Route("team/form",name="team")
     */
    public function addTeam(Request $req){

        if ($req->isMethod("POST")){
            $entityManager = $this->getDoctrine()->getManager();
            $clubId = $req->get("clubId");
            $club = $this->getDoctrine()->getRepository(Club::class)->find($clubId);

            $lastName = $req->get("inputCaptainLastName");
            $firstName = $req->get("inputCaptainFirstName");
            $mail = $req->get("inputCaptainMail");
            $phoneNumber = $req->get("inputCaptainPhoneNumber");
            $volleyballCourtId = $req->get("selectVolleyballCourt");

            $team = new Team(1, $club, $mail, "", $phoneNumber, "TeamName", $firstName, $lastName, 1);
            $entityManager->persist($team);
            $entityManager->flush();
            return $this->render('team/team.form.html.twig');
        }

        $clubId = $req->get('clubId');
        return $this->render("team/team.form.html.twig",['clubId' => $clubId]);
    }
}