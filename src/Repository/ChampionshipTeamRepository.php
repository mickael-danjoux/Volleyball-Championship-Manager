<?php


namespace App\Repository;


use App\Entity\ChampionshipTeam;

interface ChampionshipTeamRepository
{
    public function get(int $id): ChampionshipTeam;
    public function getAll(): array;
    public function save(ChampionshipTeam $championship): void;
}