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
     * @Route("/club", name="clubs")
     */
    public function getClubs(Request $req)
    {

        if ($req->isMethod('GET')) {

            $clubs = $this->getDoctrine()
                ->getRepository(Club::class)
                ->findAll();

            return $this->render('club/club.list.html.twig', ['clubs' => $clubs], new Response(200));

        } else if ($req->isMethod('POST')) {

            $clubName = $req->get("searchClub");
            $clubs = $this->getDoctrine()
                ->getRepository(Club::class)
                ->findBy(array('name' => $clubName));

            return $this->render('club/club.list.html.twig', ['clubs' => $clubs], new Response(200));
        }

        return $this->redirect($req->getUri());
    }

    /**
     * @Route("/club/form", name="club")
     */
    public function clubForm(Request $req)
    {

        if ($req->isMethod('GET')) {

            if ($req->get('clubId') != null) {

                $id = $req->get('clubId');
                $club = $this->getDoctrine()->getRepository(Club::class)->find($id);

                return $this->render('club/club.form.html.twig', [
                    'clubId' => $id,
                    'name' => $club->getName(),
                    'managerLastName' => $club->getManagerLastName(),
                    'managerFirstName' => $club->getManagerFirstName(),
                    'email' => $club->getEmail(),
                    'phoneNumber' => $club->getPhoneNumber(),
                    'active' => $club->getActive()
                ], new Response(200));

            } else {

                return $this->render('club/club.form.html.twig', [], new Response(200));
            }

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
            if ($club !== null) {
                $club->setAccount($name, $managerLastName, $managerFirstName, $email, $phoneNumber, $active);
            } else {
                $club = new Club($email, $password, $phoneNumber, $name, $managerFirstName, $managerLastName, $active);
            }

            $entityManager->persist($club);
            $entityManager->flush();

            return $this->redirectToRoute('clubs');

        } else if ($req->isMethod('DELETE')) {

            $entityManager = $this->getDoctrine()->getManager();

            $id = $req->get("id");
            $club = $this->getDoctrine()->getRepository(Club::class)->find($id);

            $entityManager->remove($club);
            $entityManager->flush();

            return $this->redirectToRoute('clubs');
        }
        return null;
    }



}