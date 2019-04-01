<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    }
}