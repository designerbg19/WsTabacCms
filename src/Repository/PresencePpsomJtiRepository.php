<?php

namespace App\Repository;

use App\Entity\PresencePpsomJti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PresencePpsomJti|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresencePpsomJti|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresencePpsomJti[]    findAll()
 * @method PresencePpsomJti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresencePpsomJtiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PresencePpsomJti::class);
    }

    // /**
    //  * @return PresencePpsomJti[] Returns an array of PresencePpsomJti objects
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
    public function findOneBySomeField($value): ?PresencePpsomJti
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
