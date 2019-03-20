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
     * @ORM\ManyToOne(targetEntity="App\Entity\Club", inversedBy="volleyballCourts")
     */
    private $club;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TimeSlot", mappedBy="volleyballCourt")
     */
    private $timeSlots;


    public function __construct($id, $place, $club, $timeSlots)
    {
        $this->id = $id;
        $this->place = $place;
        $this->club = $club;
        $this->timeSlots = $timeSlots;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getPlace(): String
    {
        return $this->place;
    }

    public function getClub(): Club
    {
        return $this->club;
    }

    public function getTimeSlots(): TimeSlot
    {
        return $this->timeSlots;
    }



}