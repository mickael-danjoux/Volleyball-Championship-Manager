<?php
<<<<<<< HEAD


namespace App\Controller;

=======
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 01/04/2019
 * Time: 09:00
 */

namespace App\Controller;


use App\Entity\Club;
use App\Entity\Team;
>>>>>>> e1523c65dc42bb1fcbb228973bbba032e79f88f9
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

<<<<<<< HEAD
use App\Entity\Team;
use App\Entity\Club;

class TeamController extends AbstractController
{

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

        $clubId = $req->get('id');
        return $this->render("team/team.form.html.twig",['clubId' => $clubId]);
=======
class TeamController extends AbstractController
{
    /**
     * @Route("/club/team", name="club-team")
     */
    public function getTeams(Request $req) {

        if ($req->isMethod('GET')) {
            $teams = $this->getDoctrine()
                ->getRepository(Team::class)
                ->findAll();

            $clubId = $req->get("clubId");

            return $this->render('team/team.list.html.twig', ['teams' => $teams, "clubId" => $clubId], new Response(200));
        }

        return null;
    }

    /**
     * @Route("/club/team/form", name="team")
     */
    public function teamForm(Request $req)
    {

        if ($req->isMethod('GET')) {

            if ($req->get('id') != null) {

                $id = $req->get('id');
                $club = $this->getDoctrine()->getRepository(Club::class)->find($id);

                return $this->render('team/team.form.html.twig', [
                    'id' => $id,
                    'name' => $club->getName(),
                    'managerLastName' => $club->getManagerLastName(),
                    'managerFirstName' => $club->getManagerFirstName(),
                    'email' => $club->getEmail(),
                    'phoneNumber' => $club->getPhoneNumber(),
                    'active' => $club->getActive()
                ], new Response(200));

            } else {

                return $this->render('team/team.form.html.twig', [], new Response(200));
            }

        }
        return null;
>>>>>>> e1523c65dc42bb1fcbb228973bbba032e79f88f9
    }
}