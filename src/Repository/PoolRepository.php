<?php


namespace App\Repository;

use App\Entity\Pool;


interface PoolRepository
{
    public function get(int $id): Pool;
    public function getAll(): array;
    public function save(Pool $pool): void;
    public function remove(Pool $pool): void;
}