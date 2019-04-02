<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 01/04/2019
 * Time: 17:10
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Cup
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
     * @ORM\Column(type="integer")
     */
    private $playoff;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Team", mappedBy="cup")
     */
    private $participatingTeams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Match", mappedBy="cup")
     */
    private $cupMatch;

    /**
     * Cup constructor.
     * @param $name
     * @param $playoff
     * @param $participatingTeams
     * @param $cupMatch
     */
    public function __construct($name, $playoff, $participatingTeams, $cupMatch)
    {
        $this->name = $name;
        $this->playoff = $playoff;
        $this->participatingTeams = $participatingTeams;
        $this->cupMatch = $cupMatch;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): String
    {
        return $this->name;
    }

    public function getPlayoff(): int
    {
        return $this->playoff;
    }

    public function getParticipatingTeams(): array
    {
        return $this->participatingTeams;
    }

    public function getCupMatch(): array
    {
        return $this->cupMatch;
    }




}