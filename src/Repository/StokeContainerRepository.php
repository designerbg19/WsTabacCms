<?php

namespace App\Repository;

use App\Entity\StokeContainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StokeContainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method StokeContainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method StokeContainer[]    findAll()
 * @method StokeContainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StokeContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StokeContainer::class);
    }
    public function getAll_Id()
    {
        return $this->createQueryBuilder('s')
          //  ->innerJoin('s.stoke','st')
            ->select('s.id')
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return StokeContainer[] Returns an array of StokeContainer objects
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
    public function findOneBySomeField($value): ?StokeContainer
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
