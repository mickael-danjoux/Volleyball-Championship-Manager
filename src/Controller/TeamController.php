<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 01/04/2019
 * Time: 09:00
 */

namespace App\Controller;


use App\Entity\Club;
use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

            return $this->render('team/team.list.html.twig', ['teams' => $teams], new Response(200));
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
    }
}