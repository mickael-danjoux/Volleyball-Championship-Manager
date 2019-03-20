<?php


namespace App\Entity;


class Set
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
    private $setNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $setPointHomeTeam;

    /**
     * @ORM\Column(type="integer")
     */
    private $setPointOutsideTeam;

    /**
     * Set constructor.
     * @param $setNumber
     * @param $setPointHomeTeam
     * @param $setPointOutsideTeam
     */
    public function __construct($setNumber, $setPointHomeTeam, $setPointOutsideTeam)
    {
        $this->setNumber = $setNumber;
        $this->setPointHomeTeam = $setPointHomeTeam;
        $this->setPointOutsideTeam = $setPointOutsideTeam;
    }

    public function getId():void
    {
        return $this->id;
    }

    public function getSetNumber():int
    {
        return $this->setNumber;
    }


    public function getSetPointHomeTeam():int
    {
        return $this->setPointHomeTeam;
    }


    public function getSetPointOutsideTeam():int
    {
        return $this->setPointOutsideTeam;
    }



}