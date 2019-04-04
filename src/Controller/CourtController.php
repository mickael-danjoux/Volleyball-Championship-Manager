<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 03/04/2019
 * Time: 14:04
 */

namespace App\Controller;

use App\Entity\Club;
use App\Entity\VolleyballCourt;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourtController extends AbstractController
{
    /**
     * @Route("/club/court", name="courts")
     */
    public function getTeams(Request $req) {

        if ($req->isMethod('GET')) {

            $clubId = $req->get("clubId");

            $club = $this->getDoctrine()
                ->getRepository(Club::class)
                ->find($clubId);

            $courts = $this->getDoctrine()
                ->getRepository(VolleyballCourt::class)
                ->findBy(array('club' => $club));

            return $this->render('court/court.list.html.twig', ['courts' => $courts, 'club' => $club], new Response(200));
        }

        return null;
    }

    /**
     * @Route("/court/form",name="court")
     */
    public function teamForm(Request $req)
    {

        if ($req->isMethod('GET')) {

            if ($req->get('courtId') != null && $req->get('clubId') != null) {

                $courtId = $req->get('courtId');
                $court = $this->getDoctrine()->getRepository(VolleyballCourt::class)->find($courtId);

                return $this->render('court/court.form.html.twig', [
                    'court' => $court
                ], new Response(200));

            } else {

                return $this->render('court/court.form.html.twig', [], new Response(200));
            }

        } else if ($req->isMethod("POST")){

            $entityManager = $this->getDoctrine()->getManager();

            $clubId = $req->get("clubId");
            $club = $this->getDoctrine()->getRepository(Club::class)->find($clubId);

            $courtId = $req->get("courtId");
            $courtPlace = $req->get("courtPlace");
            $timeSlots = $req->get("timeSlots");

            $court = new VolleyballCourt($courtPlace, $club);

            $entityManager->persist($court);
            $entityManager->flush();

            return $this->redirectToRoute('courts', ['clubId' => $clubId]);
        }
    }
}