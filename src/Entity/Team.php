<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 18/03/2019
 * Time: 13:48
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @ORM\Entity
 */
class Team extends Account
{

    /**
     * @ORM\Column(type="boolean")
     */
    private $validate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Club", inversedBy="teams")
     */
    private $club;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\VolleyballCourt", inversedBy="teams", cascade={"persist"})
     */
    private $volleyballCourts;

    public function __construct($validate, $club, $volleyballCourts, $email, $password, $phoneNumber, $name, $managerFirstName, $managerLastName, $active)
    {
        $this->validate = $validate;
        $this->club = $club;
        $this->volleyballCourts = $volleyballCourts;
        parent::__construct($email, $password, $phoneNumber, $name, $managerFirstName, $managerLastName, $active);
    }

    public function setTeam($name, $managerLastName, $managerFirstName, $email, $phoneNumber, $active, $validate, $volleyballCourts): void
    {
        $this->validate = $validate;
        $this->volleyballCourts = $volleyballCourts;
        $this->setAccount($name, $managerLastName, $managerFirstName, $email, $phoneNumber, $active);
    }

    public function getValidate(): bool
    {
        return $this->validate;
    }

    public function getClub(): Club
    {
        return $this->club;
    }

    public function getVolleyballCourts()
    {
        return $this->volleyballCourts;
    }



}