<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 03/04/2019
 * Time: 14:04
 */

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Day;
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

        } else if ($req->isMethod('DELETE')) {

            $entityManager = $this->getDoctrine()->getManager();

            $id = $req->get("id");
            $court = $this->getDoctrine()->getRepository(VolleyballCourt::class)->find($id);

            $entityManager->remove($court);
            $entityManager->flush();

            return $this->redirectToRoute('courts');
        }

        return null;
    }

    /**
     * @Route("/court/form",name="court")
     */
    public function courtForm(Request $req)
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
            $place = $req->get("place");
            $address = $req->get("address");
            $monday = $req->get("monday");
            $tuesday = $req->get("tuesday");
            $wednesday = $req->get("wednesday");
            $thursday = $req->get("thursday");
            $friday = $req->get("friday");
            $saturday = $req->get("saturday");
            $sunday = $req->get("sunday");

            $days = $this->getDoctrine()->getRepository(Day::class);
            $courtDays = [];
            if ($monday == 'on') {
                array_push($courtDays, $days->find(1));
            }
            if ($tuesday == 'on') {
                array_push($courtDays, $days->find(2));
            }
            if ($wednesday == 'on') {
                array_push($courtDays, $days->find(3));
            }
            if ($thursday == 'on') {
                array_push($courtDays, $days->find(4));
            }
            if ($friday == 'on') {
                array_push($courtDays, $days->find(5));
            }
            if ($saturday == 'on') {
                array_push($courtDays, $days->find(6));
            }
            if ($sunday == 'on') {
                array_push($courtDays, $days->find(7));
            }

            $court = $this->getDoctrine()->getRepository(VolleyballCourt::class)->find($courtId);
            if ($court !== null) {
                $court->setVolleyBallCourt($place, $address, $courtDays);
            } else {
                $court = new VolleyballCourt($place, $address, $club, $courtDays);
            }

            $entityManager->persist($court);
            $entityManager->flush();

            return $this->redirectToRoute('courts', ['clubId' => $clubId]);
        }
    }
}