<?php

namespace App\Repository;

use App\Entity\Stoke;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Stoke|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stoke|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stoke[]    findAll()
 * @method Stoke[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StokeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stoke::class);
    }
    public function findStokeByContainerID($value , $value2)
    {
        $qb = $this->_em->createQueryBuilder();
        $result =
            $qb->select('S.id,p.id as produit_Id')
                ->from('App\Entity\Stoke', 'S')
                ->innerJoin('App\Entity\StokeContainer', 'Sc')
                ->innerjoin('App\Entity\Produit', 'p')
                ->andWhere('S.produit= p.id')
                ->andWhere('S.stokeContainer = :val')
                ->andWhere('S.stokeContainer= Sc.id')
                ->andWhere('S.produit = :val2')
                ->setParameter('val', $value)
                ->setParameter('val2', $value2)
                ->getQuery()
                ->getResult();
        return $result;
    }



    // /**
    //  * @return Stoke[] Returns an array of Stoke objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stoke
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
