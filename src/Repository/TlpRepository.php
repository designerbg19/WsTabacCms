<?php

namespace App\Repository;

use App\Entity\Tlp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tlp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tlp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tlp[]    findAll()
 * @method Tlp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TlpRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tlp::class);
    }

    // /**
    //  * @return Tlp[] Returns an array of Tlp objects
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
    public function findOneBySomeField($value): ?Tlp
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
