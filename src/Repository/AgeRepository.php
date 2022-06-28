<?php

namespace App\Repository;

use App\Entity\Age;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Age|null find($id, $lockMode = null, $lockVersion = null)
 * @method Age|null findOneBy(array $criteria, array $orderBy = null)
 * @method Age[]    findAll()
 * @method Age[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Age::class);
    }

    // /**
    //  * @return Age[] Returns an array of Age objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Age
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findage()
    {
        return $this->createQueryBuilder('a')
            ->select('a.id','a.age as label')
            ->getQuery()
            ->getResult();
    }
}
