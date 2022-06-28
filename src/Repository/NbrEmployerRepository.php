<?php

namespace App\Repository;

use App\Entity\NbrEmployer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NbrEmployer|null find($id, $lockMode = null, $lockVersion = null)
 * @method NbrEmployer|null findOneBy(array $criteria, array $orderBy = null)
 * @method NbrEmployer[]    findAll()
 * @method NbrEmployer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NbrEmployerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NbrEmployer::class);
    }

    // /**
    //  * @return NbrEmployer[] Returns an array of NbrEmployer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findnbrEmpolyer()
    {
        return $this->createQueryBuilder('n')
            ->select('n.id','n.nbremployer as label')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?NbrEmployer
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
