<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{

    /**
     * @Route("team/form",name="team")
     */
    public function addTeam(Request $req){
        if($req->isMethod("GET")){
            return $this->render("team/team.form.html.twig");
        }
        elseif ($req->isMethod("POST")){
            $entityManager = $this->getDoctrine()->getManager();
            $lastName = $req->get("inputCaptainLastName");
            $firstName = $req->get("inputCaptainfirstName");
            $mail = $req->get("inputCaptainMail");
            $phoneNumber = $req->get("inputCaptainPhoneNumber");
            $volleyballCourtId = $req->get("selectVolleyballCourt");

            $account = new Account($mail, "", $phoneNumber, "nameTeam", $firstName, $lastName, $volleyballCourtId);
            $entityManager->persist($account);
            $entityManager->flush();
            return $this->render('club/club.form.html.twig');
        }
    }
}