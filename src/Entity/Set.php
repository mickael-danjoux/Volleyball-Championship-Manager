<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Set
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $setNumber;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $setPointHomeTeam;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $setPointOutsideTeam;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="sets")
     */
    private $match;
    /**
     * Set constructor.
     * @param $setNumber
     * @param $setPointHomeTeam
     * @param $setPointOutsideTeam
     * @param $match
     */
    public function __construct($setNumber, $setPointHomeTeam, $setPointOutsideTeam, $match)
    {
        $this->setNumber = $setNumber;
        $this->setPointHomeTeam = $setPointHomeTeam;
        $this->setPointOutsideTeam = $setPointOutsideTeam;
        $this->match = $match;
    }
    public function getId():int
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
    public function getMatch(): int
    {
        return $this->match;
    }
}