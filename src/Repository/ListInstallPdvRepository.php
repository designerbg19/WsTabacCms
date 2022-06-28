<?php

namespace App\Repository;

use App\Entity\ListInstallPdv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ListInstallPdv|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListInstallPdv|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListInstallPdv[]    findAll()
 * @method ListInstallPdv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListInstallPdvRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ListInstallPdv::class);
    }



     /**
      * @return ListInstallPdv[] Returns an array of ListInstallPdv objects
      */

    public function customFindAllByMerch($value)
    {
        return $this->createQueryBuilder('l')
            ->select('l')
            ->andWhere('l.merchId = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }





    // /**
    //  * @return ListInstallPdv[] Returns an array of ListInstallPdv objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListInstallPdv
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
