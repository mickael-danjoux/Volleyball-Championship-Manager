<?php


namespace App\Exception;


class PoolNotFound extends \DomainException
{
    public function __construct(int $id)
    {
        parent::__construct("Pool '" . $id . "' not found");
    }
}