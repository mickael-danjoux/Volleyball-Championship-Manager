<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends AbstractController
{
    /**
     * Charge des templates à la volée en fonction du slug
     * @Route("/page/{slug}", name="page")
     */
    public function index($slug)
    {
        // Protection pour éviter les attaques
        if (strpos($slug, '.') !== false | strpos($slug, '/') !== false | strpos($slug, '\\') !== false || !file_exists($this->getParameter('kernel.project_dir') . '/templates/page/' . $slug . '.html.twig')) {
            throw $this->createNotFoundException();
        }
        
        return $this->render('page/'. $slug .'.html.twig', []);
    }
}
