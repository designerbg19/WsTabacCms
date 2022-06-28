<?php

namespace App\Repository;

use App\Entity\InstallPresentoireJti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InstallPresentoireJti|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstallPresentoireJti|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstallPresentoireJti[]    findAll()
 * @method InstallPresentoireJti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstallPresentoireJtiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InstallPresentoireJti::class);
    }

    // /**
    //  * @return InstallPresentoireJti[] Returns an array of InstallPresentoireJti objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InstallPresentoireJti
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
