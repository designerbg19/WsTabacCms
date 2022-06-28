<?php

namespace App\Repository;

use App\Entity\PdvTypologies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvTypologies|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvTypologies|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvTypologies[]    findAll()
 * @method PdvTypologies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvTypologiesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvTypologies::class);
    }

    // /**
    //  * @return PdvTypologies[] Returns an array of PdvTypologies objects
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
    public function findOneBySomeField($value): ?PdvTypologies
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
