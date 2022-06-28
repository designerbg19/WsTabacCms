<?php

namespace App\Repository;

use App\Entity\PresencePresentoireJti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PresencePresentoireJti|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresencePresentoireJti|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresencePresentoireJti[]    findAll()
 * @method PresencePresentoireJti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresencePresentoireJtiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PresencePresentoireJti::class);
    }

    // /**
    //  * @return PresencePresentoireJti[] Returns an array of PresencePresentoireJti objects
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
    public function findOneBySomeField($value): ?PresencePresentoireJti
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
