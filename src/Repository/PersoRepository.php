<?php

namespace App\Repository;

use App\Entity\Perso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Perso|null find($id, $lockMode = null, $lockVersion = null)
 * @method Perso|null findOneBy(array $criteria, array $orderBy = null)
 * @method Perso[]    findAll()
 * @method Perso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Perso::class);
    }

    // /**
    //  * @return Perso[] Returns an array of Perso objects
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
    public function findOneBySomeField($value): ?Perso
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
