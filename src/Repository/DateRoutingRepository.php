<?php

namespace App\Repository;

use App\Entity\DateRouting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DateRouting|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateRouting|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateRouting[]    findAll()
 * @method DateRouting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateRoutingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DateRouting::class);
    }

    // /**
    //  * @return DateRouting[] Returns an array of DateRouting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DateRouting
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
