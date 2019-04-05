<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class SpecificationPoint
{
    /**
     * @ORM\Column(type="integer")
     */
    private $winPoint;

    /**
     * @ORM\Column(type="integer")
     */
    private $loosePoint;

    /**
     * @ORM\Column(type="integer")
     */
    private $forfeitPoint;

    /**
     * @ORM\Column(type="integer")
     */
    private $looseWithBonusPoint;

    public function __construct(int $winPoint, int $loosePoint, int $forfeitPoint, int $looseWithBonusPoint)
    {
        $this->winPoint = $winPoint;
        $this->loosePoint = $loosePoint;
        $this->forfeitPoint = $forfeitPoint;
        $this->looseWithBonusPoint = $looseWithBonusPoint;
    }


    public function getWinPoint(): ?int
    {
        return $this->winPoint;
    }

    public function getLoosePoint(): ?int
    {
        return $this->loosePoint;
    }

    public function getForfeitPoint(): ?int
    {
        return $this->forfeitPoint;
    }

    public function getLooseWithBonusPoint(): ?int
    {
        return $this->looseWithBonusPoint;
    }
}
