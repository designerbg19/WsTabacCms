<?php

namespace App\Repository;

use App\Entity\PlvTemporaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PlvTemporaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlvTemporaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlvTemporaire[]    findAll()
 * @method PlvTemporaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlvTemporaireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlvTemporaire::class);
    }

    // /**
    //  * @return PlvTemporaire[] Returns an array of PlvTemporaire objects
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
    public function findOneBySomeField($value): ?PlvTemporaire
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
