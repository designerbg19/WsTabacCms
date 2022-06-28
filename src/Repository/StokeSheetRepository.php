<?php

namespace App\Repository;

use App\Entity\StokeSheet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StokeSheet|null find($id, $lockMode = null, $lockVersion = null)
 * @method StokeSheet|null findOneBy(array $criteria, array $orderBy = null)
 * @method StokeSheet[]    findAll()
 * @method StokeSheet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StokeSheetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StokeSheet::class);
    }

    // /**
    //  * @return StokeSheet[] Returns an array of StokeSheet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StokeSheet
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
