<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DoctrineChampionshipTeamRepository")
 */
class ChampionshipTeam
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $point;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pool", inversedBy="championshipTeams")
     */
    private $pool;


    public function __construct(int $point, Team $team, Pool $pool)
    {
        $this->point = $point;
        $this->team = $team;
        $this->pool = $pool;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function getPool(): ?Pool
    {
        return $this->pool;
    }
}
