<?php

namespace App\Repository;

use App\Entity\RapportTlp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RapportTlp|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportTlp|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportTlp[]    findAll()
 * @method RapportTlp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportTlpRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RapportTlp::class);
    }

    // /**
    //  * @return RapportTlp[] Returns an array of RapportTlp objects
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
    public function findOneBySomeField($value): ?RapportTlp
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
