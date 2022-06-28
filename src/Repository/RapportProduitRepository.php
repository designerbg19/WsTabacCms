<?php

namespace App\Repository;

use App\Entity\RapportProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RapportProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportProduit[]    findAll()
 * @method RapportProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportProduitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RapportProduit::class);
    }

    // /**
    //  * @return RapportProduit[] Returns an array of RapportProduit objects
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
    public function findOneBySomeField($value): ?RapportProduit
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
