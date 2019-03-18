<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    private $id;

    /**
    * @Assert\NotBlank(message="Vous devez obligatoirement remplir ce champ")
    * @Assert\Length(
    * min=2,
    * max=100,
    * minMessage = "Votre prénom doit contenir au minimum {{ limit }} cacactères",
    * maxMessage = "Votre prénom doit contenir au maximum {{ limit }} cacactères")
    */
    private $firstName;

    /**
    * @Assert\NotBlank(message="Vous devez obligatoirement remplir ce champ")
    * @Assert\Length(
    * min=2,
    * max=100,
    * minMessage= "Votre nom doit contenir au minimum {{ limit }} cacactères",
    * maxMessage = "Votre prénom doit contenir au maximum {{ limit }} cacactères")
    */
    private $lastName;

    /**
    * @Assert\NotBlank(message="Vous devez obligatoirement remplir ce champ")
    * @Assert\Length(
    * min=2,
    * max=255,
    * minMessage = "L'adresse doit contenir au miimum {{ limit }} caractères",
    * maxMessage = "L'adresse doit contneir au maximum {{ limit }} caractères")
    */
    private $address;

    /**
    * @Assert\NotBlank(message="Vous devez obligatoirement remplir ce champ")
    */
    private $zipCode;

    /**
    * @Assert\NotBlank(message="Vous devez obligatoirement remplir ce champ")
    */
    private $city;

    /**
    * @Assert\NotBlank(message="Vous devez obligatoirement remplir ce champ")
    * @Assert\Regex(pattern="/[0-9]{10}/", message="Le téléphone doit contenir 10 chiffres")
    */
    private $phone;

    /**
    * @Assert\NotBlank(message="Vous devez obligatoirement remplir ce champ")
    * @Assert\Email(message="Cette adresse email n'est pas valide", checkMX = true)
    */
    private $email;

    /**
    * @Assert\NotBlank(message="Vous devez obligatoirement remplir ce champ")
    * @Assert\Length(min=2, minMessage="Votre message doit contenir au minimum 2 caractères")
    */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
