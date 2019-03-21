<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 20/03/2019
 * Time: 15:12
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class TimeSlot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VolleyballCourt", inversedBy="timeSlots")
     */
    private $volleyballCourt;


    public function __construct($startTime, $endTime, $volleyballCourt)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->volleyballCourt = $volleyballCourt;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getStartTime(): \DateTime
    {
        return $this->startTime;
    }

    public function getEndTime(): \DateTime
    {
        return $this->endTime;
    }

    public function getVolleyballCourt(): VolleyballCourt
    {
        return $this->volleyballCourt;
    }




}