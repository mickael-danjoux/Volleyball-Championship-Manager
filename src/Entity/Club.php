<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 18/03/2019
 * Time: 12:21
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Club extends Account
{

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="club")
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VolleyballCourt", mappedBy="club")
     */
    private $volleyballCourts;

    public function __construct($email, $password, $phoneNumber, $name, $managerFirstName, $managerLastName, $active)
    {
        parent::__construct($email, $password, $phoneNumber, $name, $managerFirstName, $managerLastName, $active);
    }


    public function getTeams()
    {
        return $this->teams;
    }

    public function getVolleyballCourts(): array
    {
        return $this->volleyballCourts;
    }



}