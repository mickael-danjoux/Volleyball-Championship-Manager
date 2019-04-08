<?php


namespace App\Exception;


class ChampionshipTeamNotFound extends \DomainException
{
    public function __construct(int $id)
    {
        parent::__construct("Championship team '" . $id . "' not found");
    }
}