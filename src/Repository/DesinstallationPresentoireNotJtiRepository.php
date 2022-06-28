<?php

namespace App\Repository;

use App\Entity\DesinstallationPresentoireNotJti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DesinstallationPresentoireNotJti|null find($id, $lockMode = null, $lockVersion = null)
 * @method DesinstallationPresentoireNotJti|null findOneBy(array $criteria, array $orderBy = null)
 * @method DesinstallationPresentoireNotJti[]    findAll()
 * @method DesinstallationPresentoireNotJti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DesinstallationPresentoireNotJtiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DesinstallationPresentoireNotJti::class);
    }

    // /**
    //  * @return DesinstallationPresentoireNotJti[] Returns an array of DesinstallationPresentoireNotJti objects
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
    public function findOneBySomeField($value): ?DesinstallationPresentoireNotJti
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
