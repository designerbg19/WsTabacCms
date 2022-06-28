<?php

namespace App\Repository;

use App\Entity\QuantiterTypePlv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuantiterTypePlv|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuantiterTypePlv|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuantiterTypePlv[]    findAll()
 * @method QuantiterTypePlv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuantiterTypePlvRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuantiterTypePlv::class);
    }

    // /**
    //  * @return QuantiterTypePlv[] Returns an array of QuantiterTypePlv objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function quantiter()
    {
        return $this->createQueryBuilder('q')

            ->select('q.id','q.quantiter as label')
            ->getQuery()
            ->getResult()
            ;
    }
    /*
    public function findOneBySomeField($value): ?QuantiterTypePlv
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
