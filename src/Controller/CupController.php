<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 01/04/2019
 * Time: 16:15
 */

namespace App\Controller;


use App\Entity\Cup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CupController extends AbstractController
{
    /**
     * @Route("/cups", name="cups")
     */
    public function getCups(Request $req)
    {
        if ($req->isMethod('GET')) {

            $clubs = $this->getDoctrine()
                ->getRepository(Cup::class)
                ->findAll();

            return $this->render('cup/cup.list.html.twig', [], new Response(200));
        }
    }
}