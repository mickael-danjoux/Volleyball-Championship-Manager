<?php


namespace App\Repository;


use App\Entity\Championship;

interface ChampionshipRepository
{
    public function get(int $id): Championship;
    public function getAll(): array;
    public function save(Championship $championship): void;
}