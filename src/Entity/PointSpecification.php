<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class PointSpecification
{
    /**
     * @ORM\Column(type="integer")
     */
    private $win;

    /**
     * @ORM\Column(type="integer")
     */
    private $loose;

    /**
     * @ORM\Column(type="integer")
     */
    private $forfeit;

    /**
     * @ORM\Column(type="integer")
     */
    private $looseWithBonus;

    public function __construct(int $win, int $loose, int $forfeit, int $looseWithBonus)
    {
        $this->win = $win;
        $this->loose = $loose;
        $this->forfeit = $forfeit;
        $this->looseWithBonus = $looseWithBonus;
    }

    public function getWin(): int
    {
        return $this->win;
    }

    public function getLoose(): int
    {
        return $this->loose;
    }

    public function getForfeit(): int
    {
        return $this->forfeit;
    }

    public function getLooseWithBonus(): int
    {
        return $this->looseWithBonus;
    }
}