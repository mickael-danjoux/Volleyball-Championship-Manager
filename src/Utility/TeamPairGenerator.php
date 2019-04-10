<?php


namespace App\Utility;


use Doctrine\Common\Collections\Collection;

class TeamPairGenerator
{
    private $participatingTeams;
    private $numberOfTeam;
    private $numberOfHomeMatchInPhase;

    private $teamPairs;
    private $homeMatchTeamCounterPhaseOne;
    private $homeMatchTeamCounterPhaseReturn;

    public function __construct(Collection $participatingTeams)
    {
        $this->participatingTeams = $participatingTeams;
        $this->numberOfTeam = count( $this->participatingTeams );
        $this->numberOfHomeMatchInPhase =  ceil(($this->numberOfTeam - 1) / 2);
        $this->teamPairs = [];

        $this->homeMatchTeamCounterPhaseOne = [];
        $this->homeMatchTeamCounterPhaseReturn = [];

        $this->initialiseMatchCounter();
    }

    public function generateTeamPair()
    {
        for( $i = 0; $i < $this->numberOfTeam; $i++ ){
            foreach ( $this->participatingTeams as $participatingTeam ){

                if( $this->participatingTeams[$i]->getId() !== $participatingTeam->getId() ) {

                    $matchPairAway = [
                        "home" => $this->participatingTeams[$i],
                        "outside" => $participatingTeam,
                        "phase-one" => true
                    ];

                    $matchPairAwayReverse = [
                        "home" => $participatingTeam,
                        "outside" => $this->participatingTeams[$i],
                        "phase-one" => true
                    ];

                    if ( ! in_array( $matchPairAway, $this->teamPairs ) ) {
                        if( in_array( $matchPairAwayReverse, $this->teamPairs ) ){
                            $matchPairAway['phase-one'] = false;
                        }
                        else{
                            if( $this->homeMatchTeamCounterPhaseOne[ $this->participatingTeams[$i]->getId() ] >= $this->numberOfHomeMatchInPhase ){
                                $matchPairAway['phase-one'] = false;
                            }

                            $this->homeMatchTeamCounterPhaseOne[ $this->participatingTeams[$i]->getId() ]++;
                        }

                        $this->teamPairs[] = $matchPairAway;
                    }
                }
            }
        }
    }

    private function initialiseMatchCounter(): void
    {
        foreach ( $this->participatingTeams as $participatingTeam )
        {
            $this->homeMatchTeamCounterPhaseOne[ $participatingTeam->getId() ] = 0;
            $this->homeMatchTeamCounterPhaseReturn[ $participatingTeam->getId() ] = 0;
        }
    }

    public function getTeamPairs(): array
    {
        return $this->teamPairs;
    }


}