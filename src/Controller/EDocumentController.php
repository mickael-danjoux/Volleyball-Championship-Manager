<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 01/04/2019
 * Time: 16:12
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EDocumentController extends AbstractController
{
    /**
     * @Route("/edocument", name="edocuments")
     */
    public function getEDocuments(Request $req)
    {
        if ($req->isMethod('GET')) {

            return $this->render('edocument/edocument.list.html.twig', [], new Response(200));
        }
    }
}