<?php

namespace App\Repository;

use App\Entity\ClientMiniReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClientMiniReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientMiniReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientMiniReport[]    findAll()
 * @method ClientMiniReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientMiniReportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClientMiniReport::class);
    }

    // /**
    //  * @return ClientMiniReport[] Returns an array of ClientMiniReport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClientMiniReport
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
