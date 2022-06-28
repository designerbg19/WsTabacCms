<?php

namespace App\Repository;

use App\Entity\MarketingRegieTabac;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MarketingRegieTabac|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketingRegieTabac|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketingRegieTabac[]    findAll()
 * @method MarketingRegieTabac[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketingRegieTabacRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MarketingRegieTabac::class);
    }

    // /**
    //  * @return MarketingRegieTabac[] Returns an array of MarketingRegieTabac objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MarketingRegieTabac
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
