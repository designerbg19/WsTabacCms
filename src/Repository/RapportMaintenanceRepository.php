<?php

namespace App\Repository;

use App\Entity\RapportMaintenance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RapportMaintenance|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportMaintenance|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportMaintenance[]    findAll()
 * @method RapportMaintenance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportMaintenanceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RapportMaintenance::class);
    }

    // /**
    //  * @return RapportMaintenance[] Returns an array of RapportMaintenance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RapportMaintenance
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
