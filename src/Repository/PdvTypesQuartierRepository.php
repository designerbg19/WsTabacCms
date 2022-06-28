<?php

namespace App\Repository;

use App\Entity\PdvTypesQuartier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvTypesQuartier|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvTypesQuartier|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvTypesQuartier[]    findAll()
 * @method PdvTypesQuartier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvTypesQuartierRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvTypesQuartier::class);
    }

    // /**
    //  * @return PdvTypesQuartier[] Returns an array of PdvTypesQuartier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PdvTypesQuartier
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
