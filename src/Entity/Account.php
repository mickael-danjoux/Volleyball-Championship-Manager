<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 18/03/2019
 * Time: 13:34
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     */
    protected $phoneNumber;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $managerFirstName;

    /**
     * @ORM\Column(type="string")
     */
    protected $managerLastName;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;


    public function __construct($id, $email, $password, $phoneNumber, $name, $managerFirstName, $managerLastName, $active)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->phoneNumber = $phoneNumber;
        $this->name = $name;
        $this->managerFirstName = $managerFirstName;
        $this->managerLastName = $managerLastName;
        $this->active = $active;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): String
    {
        return $this->email;
    }

    public function getPassword(): String
    {
        return $this->password;
    }

    public function getPhoneNumber(): String
    {
        return $this->phoneNumber;
    }

    public function getName(): String
    {
        return $this->name;
    }

    public function getManagerFirstName(): String
    {
        return $this->managerFirstName;
    }

    public function getManagerLastName(): String
    {
        return $this->managerLastName;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

}