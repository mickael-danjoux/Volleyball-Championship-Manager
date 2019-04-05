<?php


namespace App\Controller;

use App\Entity\Pool;
use App\Exception\PoolNotFound;
use App\Repository\PoolRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PoolController extends AbstractController
{
    /**
     * @Route("/pool/{poolId}/remove", name="pool_remove")
     */
    public function removePool(int $poolId, Request $request, PoolRepository $poolRepository): Response
    {
        try{
            $pool = $poolRepository->get( $poolId );
        }
        catch(PoolNotFound $exception){
            return $this->redirectToRoute("championships_list", []);
        }

        $poolRepository->remove( $pool );

        return $this->redirectToRoute("championship_pool", [
            "championshipId" => $pool->getChampionship()->getId()
        ]);
    }
}