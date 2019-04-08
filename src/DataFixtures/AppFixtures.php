<?php

namespace App\DataFixtures;

use App\Entity\Championship;
use App\Entity\SpecificationPoint;
use App\Repository\ChampionshipRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $championshipRepository;

    private $championshipNames = [
        "Honneur",
        "Promotion honneur",
        "Fédérale 1",
        "Fédérale 2",
        "Fédérale 3"
    ];

    public function __construct(ChampionshipRepository $championshipRepository)
    {
        $this->championshipRepository = $championshipRepository;
    }

    public function load(ObjectManager $manager)
    {
        //Load championship
        foreach ( $this->championshipNames as $championshipName ){
            $championship = new Championship( $championshipName, 0, new SpecificationPoint(3,0,-1,1));
            $manager->persist($championship);
        }

        $manager->flush();
    }
}
