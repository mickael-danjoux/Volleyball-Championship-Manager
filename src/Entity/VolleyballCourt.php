<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 20/03/2019
 * Time: 15:00
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class VolleyballCourt
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
    private $place;

    /**
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Club", inversedBy="volleyballCourts")
     */
    private $club;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Day", inversedBy="volleyballCourts", cascade={"persist"})
     */
    private $days;


    public function __construct(String $place, String $address, Club $club, array $days)
    {
        $this->place = $place;
        $this->address = $address;
        $this->club = $club;
        $this->days = $days;
    }

    public function setVolleyballCourt(String $place, String $address, array $days)
    {
        $this->place = $place;
        $this->address = $address;
        $this->days = $days;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getPlace(): String
    {
        return $this->place;
    }

    public function getAddress(): String
    {
        return $this->address;
    }

    public function getClub(): Club
    {
        return $this->club;
    }

    public function getDays()
    {
        return $this->days;
    }





}