<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Championship", inversedBy="groups")
     */
    private $championship;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="id")
     */
    private $teams = [];

    public function __construct(string $name, Championship $championship)
    {
        $this->name = $name;
        $this->championship = $championship;
    }


    public function getId()
    {
        return $this->id;
    }

    public function addTeam(Team $team): void
    {
        $this->teams[] = $team;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getChampionship(): Championship
    {
        return $this->championship;
    }

    public function getTeams()
    {
        return $this->teams;
    }
}