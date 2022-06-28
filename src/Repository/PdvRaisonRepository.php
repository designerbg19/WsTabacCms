<?php

namespace App\Repository;

use App\Entity\PdvRaison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvRaison|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvRaison|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvRaison[]    findAll()
 * @method PdvRaison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvRaisonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvRaison::class);
    }

    // /**
    //  * @return PdvRaison[] Returns an array of PdvRaison objects
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
    public function findOneBySomeField($value): ?PdvRaison
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
