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
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Embedded(class="PointSpecification")
     */
    private $pointSpecification;

    /**
     * @ORM\OneToMany(targetEntity="Group", mappedBy="id")
     */
    private $groups = [];

    public function __construct(int $id, string $name, PointSpecification $pointSpecification)
    {
        $this->id = $id;
        $this->name = $name;
        $this->pointSpecification = $pointSpecification;
    }

    public function addGroup(Group $group): void
    {
        $this->groups[] = $group;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPointSpecification(): PointSpecification
    {
        return $this->pointSpecification;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }


}