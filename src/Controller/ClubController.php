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
     * @Route("/club", name="club")
     */
    public function getClubs(Request $req) {

        if ($req->isMethod('GET')){

            $clubs = $this->getDoctrine()
                ->getRepository(Club::class)
                ->findAll();

            return $this->render('club/club.list.html.twig', ['clubs' => $clubs], new Response("Affichage des clubs OK", 200));
        }
    }

    /**
     * @Route("/club/form", name="club-form")
     */
    public function createClub(Request $req) {

        if ($req->isMethod('GET')){

            $name = $req->get('name');
            $managerLastName = $req->get('managerLastName');
            $managerFirstName = $req->get('managerFirstName');
            $email = $req->get('email');
            $phoneNumber = $req->get('phoneNumber');
            $active = $req->get('active');

            return $this->render('club/club.form.html.twig', [
                'name' => $name,
                'managerLastName' => $managerLastName,
                'managerFirstName' => $managerFirstName,
                'email' => $email,
                'phoneNumber' => $phoneNumber,
                'active' => $active
            ], new Response(200));

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

            return $this->render('club/club.form.html.twig', [], new Response(200));
            //return new Response($req->get("active"));
        }
    }

}