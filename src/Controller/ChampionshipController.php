<?php


namespace App\Controller;


use App\Form\ChampionshipEditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChampionshipController extends AbstractController
{
    /**
     * @Route("/championship", name="championships_list");
     */
    public function listChampionships(): Response
    {
        $championships = [];

        return $this->render('championship/championship-list.html.twig', [
            "championships" => $championships,
            "areChampionships" => ( count($championships) > 0 )
        ]);
    }

    /**
     * @Route("/championship/edit", name="championship_edit");
     */
    public function editChampionship(Request $request): Response
    {
        $championshipId = (int) $request->get("championshipId" );
        $championshipName = $request->get("championshipName" );

        if( $request->getMethod() === "POST" ){
        }

        return $this->render('championship/championship-edit.html.twig', [
            "championshipId" => $championshipId,
            "championshipName" => $championshipName
        ]);
    }

    /**
     * @Route("/championship/{championshipId}", name="championship_page")
     */
    public function pageChampionship(int $championshipId, Request $request): Response
    {
        $championship = "ok";


        if( $championship == null ){
            return $this->redirectToRoute("championships_list");
        }


        return $this->render('championship/championship-page-unbegin.html.twig', [
            "championship" => $championship
        ]);
    }
}