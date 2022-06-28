<?php

namespace App\Repository;

use App\Entity\MarketingCampagneEnCours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MarketingCampagneEnCours|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketingCampagneEnCours|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketingCampagneEnCours[]    findAll()
 * @method MarketingCampagneEnCours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketingCampagneEnCoursRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MarketingCampagneEnCours::class);
    }

    // /**
    //  * @return MarketingCampagneEnCours[] Returns an array of MarketingCampagneEnCours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MarketingCampagneEnCours
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
