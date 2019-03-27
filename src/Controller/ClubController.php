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
    public function club(Request $req) {

        if ($req->isMethod('GET')){

            $id = $req->get('id');
            $club = $this->getDoctrine()->getRepository(Club::class)->find($id);

            return $this->render('club/club.form.html.twig', [
                'id' => $id,
                'name' => $club->getName(),
                'managerLastName' => $club->getManagerLastName(),
                'managerFirstName' => $club->getManagerFirstName(),
                'email' => $club->getEmail(),
                'phoneNumber' => $club->getPhoneNumber(),
                'active' => $club->getActive()
            ], new Response(200));

        } else if ($req->isMethod('POST')) {

            $entityManager = $this->getDoctrine()->getManager();

            $id = $req->get("id");
            $name = $req->get("name");
            $managerLastName = $req->get("managerLastName");
            $managerFirstName = $req->get("managerFirstName");
            $email = $req->get("email");
            $password = $req->get("password");
            $phoneNumber = $req->get("phoneNumber");
            $active = $req->get("active");

            $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
            if($club !== null) {
                $club->setAccount($name, $managerLastName, $managerFirstName, $email, $password, $phoneNumber, $active);
            } else {
                $club = new Club($email, $password, $phoneNumber, $name, $managerFirstName, $managerLastName, $active);
            }

            $entityManager->persist($club);

            $entityManager->flush();

            return $this->render('club/club.form.html.twig', [], new Response(200));
            //return new Response($req->get("active"));

        }
    }

}