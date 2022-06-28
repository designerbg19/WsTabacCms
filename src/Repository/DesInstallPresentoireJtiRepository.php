<?php

namespace App\Repository;

use App\Entity\DesInstallPresentoireJti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DesInstallPresentoireJti|null find($id, $lockMode = null, $lockVersion = null)
 * @method DesInstallPresentoireJti|null findOneBy(array $criteria, array $orderBy = null)
 * @method DesInstallPresentoireJti[]    findAll()
 * @method DesInstallPresentoireJti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DesInstallPresentoireJtiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DesInstallPresentoireJti::class);
    }

    // /**
    //  * @return DesInstallPresentoireJti[] Returns an array of DesInstallPresentoireJti objects
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
    public function findOneBySomeField($value): ?DesInstallPresentoireJti
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
