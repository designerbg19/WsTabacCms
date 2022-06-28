<?php

namespace App\Repository;

use App\Entity\RapportMaintListMa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RapportMaintListMa|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportMaintListMa|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportMaintListMa[]    findAll()
 * @method RapportMaintListMa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportMaintListMaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RapportMaintListMa::class);
    }

    // /**
    //  * @return RapportMaintListMa[] Returns an array of RapportMaintListMa objects
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
    public function findOneBySomeField($value): ?RapportMaintListMa
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
