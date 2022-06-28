<?php

namespace App\Repository;

use App\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Notification::class);
    }


    /**
     * Find Notifications By Cycle
     * @return Notification[] Returns an array of Notification objects
     */

    public function findNotificationsByCycle($value)
    {
        return $this->createQueryBuilder('n')
            ->leftJoin('n.merch','m')
            ->select('n.title','n.text')
            ->andWhere('n.cycleId like :val')
            ->andWhere('n.visibility = 1')
            ->setParameter('val', $value)
            ->andWhere('m.id is NULL')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Find Notifications By Cycle By Merch
     * @return Notification[] Returns an array of Notification objects
     */

    public function findNotificationsByCycleByMerch($value,$value2)
    {
        return $this->createQueryBuilder('n')
            ->leftJoin('n.merch','m')
            ->select('n.title','n.text')
            ->andWhere('n.cycleId = :val')
            ->andWhere('m.id = :val2')
            ->andWhere('n.visibility = 1')
            ->setParameter('val', $value)
            ->setParameter('val2', $value2)
            ->getQuery()
            ->getResult()
            ;

    }



    /**
     * Find Notifications By Cycle By Merch
     * @return Notification[] Returns an array of Notification objects
     */

    public function CustomFindall()
    {
        return $this->createQueryBuilder('n')
            ->leftJoin('n.merch','m')
            ->select('n.id','n.title','n.text','n.visibility','n.cycleId')
            ->distinct(true)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Find Notifications By Cycle By Merch
     * @return Notification[] Returns an array of Notification objects
     */

    public function findByMerchs($value)
    {
        return $this->createQueryBuilder('n')
            ->join('n.merch','m')
            ->select('m.id','CONCAT(m.code,\' - \',m.firstName,\' \',m.lastName) AS full_name')
            ->where('n.id = :val')
            ->orWhere('m.id is NULL')
            ->setParameter('val',$value)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Find Notifications By Cycle By Merch
     * @return Notification[] Returns an array of Notification objects
     */

    public function CustomFindallMerchs()
    {
        return $this->createQueryBuilder('n')
            ->leftJoin('n.merch','m')
            ->select('m')
            ->distinct(true)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Find Notifications with pagination
     * @return Query
     */

    public function CustomFindAllWithPagination()
    {
        $query = $this->createQueryBuilder('n')
            ->leftJoin('n.merch','m')
            ->select('n.id','n.title','n.visibility')
            ->distinct(true)
            ->getQuery()
            ;
        return $query;
    }

    // /**
    //  * @return Notification[] Returns an array of Notification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Notification
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
