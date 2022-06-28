<?php

namespace App\Repository;

use App\Entity\Deligation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Deligation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deligation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deligation[]    findAll()
 * @method Deligation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeligationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Deligation::class);
    }


    /**
     * @return Deligation[] Returns an array of  objects
     */

    public function customFindAll()
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.gouvernorat','g')
            ->select('d.id','d.label','g.id as parentId')
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Deligation[] Returns an array of Deligation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Deligation
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
