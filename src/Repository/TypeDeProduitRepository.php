<?php

namespace App\Repository;

use App\Entity\TypeDeProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeDeProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDeProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDeProduit[]    findAll()
 * @method TypeDeProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDeProduitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeDeProduit::class);
    }

    // /**
    //  * @return TypeDeProduit[] Returns an array of TypeDeProduit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeDeProduit
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
