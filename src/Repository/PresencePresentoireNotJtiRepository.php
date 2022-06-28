<?php

namespace App\Repository;

use App\Entity\PresencePresentoireNotJti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PresencePresentoireNotJti|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresencePresentoireNotJti|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresencePresentoireNotJti[]    findAll()
 * @method PresencePresentoireNotJti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresencePresentoireNotJtiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PresencePresentoireNotJti::class);
    }

    // /**
    //  * @return PresencePresentoireNotJti[] Returns an array of PresencePresentoireNotJti objects
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
    public function findOneBySomeField($value): ?PresencePresentoireNotJti
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
