<?php

namespace App\Repository;

use App\Entity\OnePlanning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OnePlanning|null find($id, $lockMode = null, $lockVersion = null)
 * @method OnePlanning|null findOneBy(array $criteria, array $orderBy = null)
 * @method OnePlanning[]    findAll()
 * @method OnePlanning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OnePlanningRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OnePlanning::class);
    }


     /**
      * @return OnePlanning[] Returns an array of OnePlanning objects
      */

    public function findByNumCycle($value)
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.cycle','c')
            ->addSelect('c')
            ->andWhere('c.numCycle = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Find OnePlanning By Cycle
     * @return OnePlanning[] Returns an array of OnePlanning objects
     */

    public function findByCycle($value)
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.cycle','c')
            ->addSelect('c')
            ->andWhere('c.id like :val')
            ->setParameter('val', $value.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Find OnePlanning By Cycle custom function
     * @return OnePlanning[] Returns an array of OnePlanning objects
     */

    public function customFindByCycle($value)
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.cycle','c')
            ->innerJoin('o.Merch','m')
            ->select('o.a','o.am','m.id as idMerch','o.classment')
            ->andWhere('c.id like :val')
            ->setParameter('val', $value.'%')
            ->getQuery()
            ->getResult()
            ;
    }



    /**
     * Find OnePlanning By Cycle
     * @return OnePlanning[] Returns an array of OnePlanning objects
     */

    public function findJustTheMerchsId($value)
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.Merch','m')
            ->addSelect('m')
            ->select('m.id')
            ->andWhere('o.cycle = :val')
            ->setParameter('val', $value)
            ->distinct(true)
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     * Find OnePlanning By Cycle
     * @return OnePlanning[] Returns an array of OnePlanning objects
     */
    public function findTheIdAndClassmentOfOnePlanningByMerchByCycle($value,$value2)
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.Merch','m')
            ->addSelect('m')
            ->select('o.id','o.classment')
            ->andWhere('o.Merch = :val')
            ->andWhere('o.cycle = :val2')
            ->setParameter('val', $value)
            ->setParameter('val2', $value2)
            ->orderBy('o.date', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }



    // /**
    //  * @return OnePlanning[] Returns an array of OnePlanning objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OnePlanning
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    //New Install PDV : for return install date
     /**
      * $value: id routing
      * $value2: id merch
      * @return OnePlanning[] Returns an array of OnePlanning objects
      */
    public function findRoutingsByMerch($AOrAm,$value,$value2)
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.Merch',"merch")
            ->select('o.date as day')
            ->andWhere('o.'.$AOrAm.' = :val')
            ->setParameter('val', $value)
            ->andWhere('merch.id = :val2')
            ->setParameter('val2', $value2)
            ->distinct(true)
            ->getQuery()
            ->getResult(Query::HYDRATE_OBJECT)
        ;
    }






}
