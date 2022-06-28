<?php

namespace App\Repository;

use App\Entity\PresenceShopJti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PresenceShopJti|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresenceShopJti|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresenceShopJti[]    findAll()
 * @method PresenceShopJti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresenceShopJtiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PresenceShopJti::class);
    }

    // /**
    //  * @return PresenceShopJti[] Returns an array of PresenceShopJti objects
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
    public function findOneBySomeField($value): ?PresenceShopJti
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
