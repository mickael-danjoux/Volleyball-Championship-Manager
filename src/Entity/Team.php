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


    public function __construct($validate, $club, $email, $password, $phoneNumber, $name, $managerFirstName, $managerLastName, $active)
    {
        $this->validate = $validate;
        $this->club = $club;
        parent::__construct($email, $password, $phoneNumber, $name, $managerFirstName, $managerLastName, $active);
    }

    public function getValidate(): bool
    {
        return $this->validate;
    }

    public function getClub(): Club
    {
        return $this->club;
    }



}