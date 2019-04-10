<?php

namespace App\DataFixtures;

use App\Entity\Championship;
use App\Entity\Club;
use App\Entity\SpecificationPoint;
use App\Entity\Team;
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

    private $clubNames = [
        "Viriat",
        "IUT Lyon 1",
        "Ceyzeriat"
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

        //Create Club
        foreach ( $this->clubNames as $clubName ){
            $club = new Club( $clubName . "@mail.com" , "123456", "0123456789", $clubName, "Jacky", "Michel", 1);
            $manager->persist( $club );

            for( $i = 0; $i < 2; $i++ ){
                $team = new Team(1, $club, $clubName . "_" . $i . "@mail.com", "123456", "0123456789", $clubName . "-" . $i, "Captain", "Morgan", 1);
                $manager->persist( $team );
            }
        }

        $manager->flush();
    }
}
