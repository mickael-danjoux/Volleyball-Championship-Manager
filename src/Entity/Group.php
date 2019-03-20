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
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="id")
     */
    private $teams = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Championship", inversedBy="groups")
     */
    private $championship;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function addTeam(Team $team): void
    {
        $this->teams[] = $team;
    }

    public function getName(): string
    {
        return $this->name;
    }
}