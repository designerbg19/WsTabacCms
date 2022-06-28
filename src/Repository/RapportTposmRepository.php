<?php

namespace App\Repository;

use App\Entity\RapportTposm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RapportTposm|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportTposm|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportTposm[]    findAll()
 * @method RapportTposm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportTposmRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RapportTposm::class);
    }

    // /**
    //  * @return RapportTposm[] Returns an array of RapportTposm objects
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
    public function findOneBySomeField($value): ?RapportTposm
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
