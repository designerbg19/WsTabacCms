<?php

namespace App\Repository;

use App\Entity\MarkTypeDeCompagne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MarkTypeDeCompagne|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarkTypeDeCompagne|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarkTypeDeCompagne[]    findAll()
 * @method MarkTypeDeCompagne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarkTypeDeCompagneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MarkTypeDeCompagne::class);
    }

    // /**
    //  * @return MarkTypeDeCompagne[] Returns an array of MarkTypeDeCompagne objects
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
    public function findOneBySomeField($value): ?MarkTypeDeCompagne
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
