<?php

namespace App\Repository;

use App\Entity\TlpStokeCourant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TlpStokeCourant|null find($id, $lockMode = null, $lockVersion = null)
 * @method TlpStokeCourant|null findOneBy(array $criteria, array $orderBy = null)
 * @method TlpStokeCourant[]    findAll()
 * @method TlpStokeCourant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TlpStokeCourantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TlpStokeCourant::class);
    }

    // /**
    //  * @return TlpStokeCourant[] Returns an array of TlpStokeCourant objects
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
    public function findOneBySomeField($value): ?TlpStokeCourant
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
