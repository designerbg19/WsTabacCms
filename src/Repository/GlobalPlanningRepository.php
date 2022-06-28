<?php

namespace App\Repository;

use App\Entity\GlobalPlanning;
use App\Entity\OnePlanning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GlobalPlanning|null find($id, $lockMode = null, $lockVersion = null)
 * @method GlobalPlanning|null findOneBy(array $criteria, array $orderBy = null)
 * @method GlobalPlanning[]    findAll()
 * @method GlobalPlanning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GlobalPlanningRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GlobalPlanning::class);
    }



    /**
     * Find the Ids of Global Planning
     * @return GlobalPlanning[] Returns an array of GlobalPlanning objects
     */

    public function findJustTheMerchsId($value)
    {
        return $this->createQueryBuilder('g')
            ->select('g.merchId')
            ->where('g.numCycle = :val')
            ->setParameter('val', $value)
            ->distinct(true)
            ->getQuery()
            ->getArrayResult();
            ;
    }

    /**
     * Find the Ids of Global Planning
     * @return GlobalPlanning[] Returns an array of GlobalPlanning objects
     */

    public function findAllByCycle($value)
    {
        return $this->createQueryBuilder('g')
            ->select('g')
            ->where('g.numCycle = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getArrayResult();
        ;
    }


    /**
     * Find GlobalPlanning By Cycle
     * @return GlobalPlanning[] Returns an array of OnePlanning objects
     */

    public function findGlobalPlanningByCycle($value)
    {
        return $this->createQueryBuilder('g')
            ->addSelect('g')
            ->andWhere('g.numCycle like :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }




    // /**
    //  * @return GlobalPlanning[] Returns an array of GlobalPlanning objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GlobalPlanning
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
