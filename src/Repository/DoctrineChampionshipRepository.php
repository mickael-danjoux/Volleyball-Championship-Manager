<?php

namespace App\Repository;

use App\Entity\Championship;
use App\Exception\ChampionshipNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use mysql_xdevapi\Exception;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * @method Championship|null find($id, $lockMode = null, $lockVersion = null)
 * @method Championship|null findOneBy(array $criteria, array $orderBy = null)
 * @method Championship[]    findAll()
 * @method Championship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineChampionshipRepository extends ServiceEntityRepository implements ChampionshipRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Championship::class);
    }

    public function get(int $id): Championship
    {
        $championship = $this->find( $id );

        if( ! $championship ){
            throw new ChampionshipNotFound( $id );
        }

        return $championship;
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function save(Championship $championship): void
    {
        $this->getEntityManager()->persist( $championship );
        $this->getEntityManager()->flush();
    }
}
