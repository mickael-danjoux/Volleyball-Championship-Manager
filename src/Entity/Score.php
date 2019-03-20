<?php


namespace App\Entity;

/**
 * @Embeddable
 */
class Score
{

    /**
     * @ORM\id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreHomeTeam;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreOutsideTeam;

    /**
    *@ORM\OneToMany(targetEntity="Set", mappedBy="match_id")
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

    public function getId():int
    {
        return $this->id;
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