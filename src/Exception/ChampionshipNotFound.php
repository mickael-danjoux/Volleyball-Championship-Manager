<?php


namespace App\Exception;

class ChampionshipNotFound extends \DomainException
{
    public function __construct(int $id)
    {
        parent::__construct("Championship '" . $id . "' not found");
    }
}