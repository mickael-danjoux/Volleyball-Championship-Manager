<?php
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="home_team_id", referencedColumnName="id",nullable=false)
     */
    private $homeTeam;
    /**
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="outside_team_id", referencedColumnName="id",nullable=true)
     */
    private $outsideTeam;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $matchDate;
    /**
     * @ORM\Embedded(class = "Score")
     */
    private $score;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $homeMatch;

    public function __construct(Team $homeTeam,Team $outsideTeam, $homeMatch)
    {
        $this->homeTeam = $homeTeam;
        $this->outsideTeam = $outsideTeam;
        $this->homeMatch = $homeMatch;
    }
    public function getId():int
    {
        return $this->id;
    }
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }
    public function getOutsideTeam()
    {
        return $this->outsideTeam;
    }
    public function getMatchDate():Assert\Date
    {
        return $this->matchDate;
    }
    public function getScore():Score
    {
        return $this->score;
    }
    public function addScore(int $scoreHomeTeam,int $scoreOutsideTeam, array $sets):void
    {
        $this->score = new Score($scoreHomeTeam,$scoreOutsideTeam,$sets);
    }

    public function getHomeMatch()
    {
        return $this->homeMatch;
    }

}