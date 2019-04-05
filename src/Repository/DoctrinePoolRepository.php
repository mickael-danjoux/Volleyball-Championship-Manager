<?php

namespace App\Repository;

use App\Entity\Pool;
use App\Exception\PoolNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pool|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pool|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pool[]    findAll()
 * @method Pool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrinePoolRepository extends ServiceEntityRepository implements PoolRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pool::class);
    }

    public function get(int $id): Pool
    {
        $pool = $this->find( $id );

        if( ! $pool ){
            throw new PoolNotFound( $id );
        }

        return $pool;
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function save(Pool $pool): void
    {
        $this->getEntityManager()->persist( $pool );
        $this->getEntityManager()->flush();
    }

    public function remove(Pool $pool): void
    {
        $this->getEntityManager()->remove( $pool );
        $this->getEntityManager()->flush();
    }
}
