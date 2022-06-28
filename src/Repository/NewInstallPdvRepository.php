<?php

namespace App\Repository;

use App\Entity\NewInstallPdv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NewInstallPdv|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewInstallPdv|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewInstallPdv[]    findAll()
 * @method NewInstallPdv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewInstallPdvRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NewInstallPdv::class);
    }


     /**
      * @return NewInstallPdv[] Returns an array of NewInstallPdv objects
      */

    public function customFindAll()
    {
        return $this->createQueryBuilder('n')
            ->select('n.id','n.merchId','n.newInstallDate')
            ->andWhere('n.visibility = :val')
            ->setParameter('val', 1)
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    // /**
    //  * @return NewInstallPdv[] Returns an array of NewInstallPdv objects
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
    public function findOneBySomeField($value): ?NewInstallPdv
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
