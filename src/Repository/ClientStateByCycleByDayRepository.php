<?php

namespace App\Repository;

use App\Entity\ClientStateByCycleByDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClientStateByCycleByDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientStateByCycleByDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientStateByCycleByDay[]    findAll()
 * @method ClientStateByCycleByDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientStateByCycleByDayRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClientStateByCycleByDay::class);
    }

    // /**
    //  * @return ClientStateByCycleByDay[] Returns an array of ClientStateByCycleByDay objects
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
    public function findOneBySomeField($value): ?ClientStateByCycleByDay
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
