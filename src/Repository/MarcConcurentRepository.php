<?php

namespace App\Repository;

use App\Entity\MarcConcurent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MarcConcurent|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarcConcurent|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarcConcurent[]    findAll()
 * @method MarcConcurent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarcConcurentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MarcConcurent::class);
    }

    // /**
    //  * @return MarcConcurent[] Returns an array of MarcConcurent objects
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
    public function findOneBySomeField($value): ?MarcConcurent
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
