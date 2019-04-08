<?php

namespace App\Repository;

use App\Entity\ChampionshipTeam;
use App\Exception\ChampionshipTeamNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChampionshipTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChampionshipTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChampionshipTeam[]    findAll()
 * @method ChampionshipTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineChampionshipTeamRepository extends ServiceEntityRepository implements ChampionshipTeamRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChampionshipTeam::class);
    }

    public function get(int $id): ChampionshipTeam
    {
        $championshipTeam = $this->find( $id );

        if( ! $championshipTeam ){
            throw new ChampionshipTeamNotFound( $id );
        }

        return $championshipTeam;
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function save(ChampionshipTeam $championshipTeam): void
    {
        $this->getEntityManager()->persist( $championshipTeam );
        $this->getEntityManager()->flush();
    }
}
