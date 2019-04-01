<?php

namespace App\Controller;


use App\Entity\Club;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{

    /**
     * @Route("/club/form", name="club")
     */
    public function createClub(Request $req) {
        if ($req->isMethod('GET')){

            return $this->render('club/club.form.html.twig');

        } else if ($req->isMethod('POST')) {

            $entityManager = $this->getDoctrine()->getManager();

            $name = $req->get("name");
            $managerFirstName = $req->get("managerFirstName");
            $managerLastName = $req->get("managerLastName");
            $email = $req->get("email");
            $password = $req->get("password");
            $phoneNumber = $req->get("phoneNumber");
            $active = $req->get("active");

            $club = new Club($email, $password, $phoneNumber, $name, $managerFirstName, $managerLastName, $active);

            $entityManager->persist($club);

            $entityManager->flush();

            return $this->render('club/club.form.html.twig');
            //return new Response($req->get("active"));
        }
    }



}