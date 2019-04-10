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
use App\Entity\VolleyballCourt;
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

        } else if ($req->isMethod('DELETE')) {

            $entityManager = $this->getDoctrine()->getManager();

            $id = $req->get("id");
            $team = $this->getDoctrine()->getRepository(Team::class)->find($id);

            $entityManager->remove($team);
            $entityManager->flush();

            return $this->redirectToRoute('teams');
        }

        return null;
    }

    /**
     * @Route("/team/form",name="team")
     */
    public function teamForm(Request $req){

        if ($req->isMethod('GET')) {
            if($req ->get('clubId') != null) {

                $clubId = $req->get('clubId');
                $club = $this->getDoctrine()->getRepository(Club::class)->find($clubId);

                if ($req->get('teamId') != null) {

                    $teamId = $req->get('teamId');
                    $team = $this->getDoctrine()->getRepository(Team::class)->find($teamId);

                    return $this->render('team/team.form.html.twig', [
                        'team' => $team,
                        'club' => $club
                    ], new Response(200));

                } else {

                    return $this->render('team/team.form.html.twig', [
                        'club' => $club
                    ], new Response(200));
                }
            } else {
                return $this ->redirectToRoute('clubs');
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
            $active = $req->get("active");
            $validate = $req->get("validate");

            $volleyballCourts = [];
            $volleyballCourtsId = $req->get("volleyballCourts");
            foreach ($volleyballCourtsId as $courtId) {
                $court = $this->getDoctrine()->getRepository(VolleyballCourt::class)->find($courtId);
                array_push($volleyballCourts, $court);
            }

            if ($validate == 0) {
                $active = 0;
            }

            $team = $this->getDoctrine()->getRepository(Team::class)->find($teamId);
            if ($team !== null) {
                $team->setTeam($teamName, $captainLastName, $captainFirstName, $email, $phoneNumber, $active, $validate, $volleyballCourts);
            } else {
                $team = new Team($validate, $club, $volleyballCourts, $email, $password, $phoneNumber, $teamName, $captainLastName, $captainFirstName, $active);
            }

            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('teams', ['clubId' => $clubId]);
        }

        $clubId = $req->get('clubId');
        return $this->render("team/team.form.html.twig",['clubId' => $clubId]);
    }
}