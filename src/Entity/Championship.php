<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Championship
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
    private $name;

    /**
     * @ORM\Column(type="smallint")
     */
    private $began;

    /**
     * @ORM\Embedded(class="SpecificationPoint")
     */
    private $pointSpecification;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Group", mappedBy="championship")
     */
    private $groups;

    public function __construct(string $name, bool $began, SpecificationPoint $pointSpecification)
    {
        $this->name = $name;
        $this->began = $began;
        $this->pointSpecification = $pointSpecification;
    }

    public function addGroup(Group $group): void
    {
        $this->groups[] = $group;
    }

    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    public function start(): void
    {
        $this->began = true;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPointSpecification(): SpecificationPoint
    {
        return $this->pointSpecification;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }

    public function getBegan(): bool
    {
        return $this->began;
    }
}