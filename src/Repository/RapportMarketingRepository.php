<?php

namespace App\Repository;

use App\Entity\RapportMarketing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RapportMarketing|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportMarketing|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportMarketing[]    findAll()
 * @method RapportMarketing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportMarketingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RapportMarketing::class);
    }

    // /**
    //  * @return RapportMarketing[] Returns an array of RapportMarketing objects
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
    public function findOneBySomeField($value): ?RapportMarketing
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
