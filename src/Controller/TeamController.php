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
     * @Route("/club/team", name="teams")
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

            return $this->render('team/team.list.html.twig', ['teams' => $teams, 'club' => $club], new Response(200));
        }

        return null;
    }

    /**
     * @Route("/team/form",name="team")
     */
    public function teamForm(Request $req){

        if ($req->isMethod('GET')) {

            if ($req->get('teamId') != null) {

                $teamId = $req->get('teamId');
                $team = $this->getDoctrine()->getRepository(Team::class)->find($teamId);

                return $this->render('team/team.form.html.twig', [
                    'team' => $team
                ], new Response(200));

            } else {

                return $this->render('team/team.form.html.twig', [], new Response(200));
            }

        } else if ($req->isMethod("POST")){

            $entityManager = $this->getDoctrine()->getManager();

            $clubId = $req->get("clubId");
            $club = $this->getDoctrine()->getRepository(Club::class)->find($clubId);

            $teamId = $req->get("teamId");
            $teamName = $req->get("teamName");
            $captainLastName = $req->get("captainLastName");
            $captainFirstName = $req->get("captainFirstName");
            $email = $req->get("captainEmail");
            $password = $req->get("password");
            $phoneNumber = $req->get("captainPhoneNumber");
            $volleyballCourtId = $req->get("volleyballCourt");
            $active = $req->get("active");

            $team = $this->getDoctrine()->getRepository(Team::class)->find($teamId);
            if ($team !== null) {
                $team->setAccount($teamName, $captainLastName, $captainFirstName, $email, $phoneNumber, $active);
            } else {
                $team = new Team(1, $club, $email, $password, $phoneNumber, $teamName, $captainLastName, $captainFirstName, 1);
            }

            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('teams', ['clubId' => $clubId]);
        }

        $clubId = $req->get('clubId');
        return $this->render("team/team.form.html.twig",['clubId' => $clubId]);
    }
}