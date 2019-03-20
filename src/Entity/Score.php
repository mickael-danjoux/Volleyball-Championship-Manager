<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Score
{

    /**
     * @ORM\Column(type="integer", name="home_team")
     */
    private $scoreHomeTeam;

    /**
     * @ORM\Column(type="integer", name="outside_team")
     */
    private $scoreOutsideTeam;

    /**
    *@ORM\OneToMany(targetEntity="Set", mappedBy="match")
    */
    private $sets;

    /**
     * Score constructor.
     * @param $scoreHomeTeam
     * @param $scoreOutsideTeam
     * @param $sets
     */
    public function __construct(int $scoreHomeTeam,int $scoreOutsideTeam,array $sets)
    {

        $this->scoreHomeTeam = $scoreHomeTeam;
        $this->scoreOutsideTeam = $scoreOutsideTeam;
        $this->sets = $sets;
    }

    public function getScoreHomeTeam():int
    {
        return $this->scoreHomeTeam;
    }


    public function getScoreOutsideTeam():int
    {
        return $this->scoreOutsideTeam;
    }


    public function getSets():array
    {
        return $this->sets;
    }

    public function addSet($setNumber, $setPointHomeTeam, $setPointOutsideTeam):void
    {
        $set = new Set($setNumber, $setPointHomeTeam, $setPointOutsideTeam);
        $this->sets[$setNumber] = $set;
    }

    public function updateSet($setNumber, $setPointHomeTeam, $setPointOutsideTeam):void{

        if(isset($this->sets[$setNumber])){
            $this->sets[$setNumber] = new Set($setNumber,$setPointHomeTeam, $setPointOutsideTeam);

        }
    }



}