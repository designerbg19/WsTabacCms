<?php

namespace App\Repository;

use App\Entity\Planning;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Planning|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planning|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planning[]    findAll()
 * @method Planning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Planning::class);
    }



    /**
     * @return Planning[] Returns an array of Planning objects
     */

    public function showId()
    {
        return $this->createQueryBuilder('p')
            ->select(array('p.id','p.numCycle','p.datePlanning','p.M','p.AM','p.mData','p.amData'))
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Planning[] Returns an array of Planning objects
     */

    public function findByNumCycle($numCycle)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query
            ->select(array('p.id ','p.numCycle','d.dateDebut','d.dateFin', 'p.M','p.AM','p.mData','p.amData','p.merchName','m.id as MerchId','p.datePlanning as jour'))
            ->from('App:Planning', 'p')
            ->leftjoin('p.Merch', 'm')
            ->leftjoin('p.dateRouting', 'd')
            ->andWhere('p.numCycle = :val')
            ->setParameter('val', $numCycle);


        $query->setMaxResults(10);
        $results = $query->getQuery()->getResult();
        return $results;
    }






    // /**
    //  * @return Planning[] Returns an array of Planning objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Planning
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
