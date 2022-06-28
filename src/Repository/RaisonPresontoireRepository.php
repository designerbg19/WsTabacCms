<?php

namespace App\Repository;

use App\Entity\RaisonPresontoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RaisonPresontoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method RaisonPresontoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method RaisonPresontoire[]    findAll()
 * @method RaisonPresontoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaisonPresontoireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RaisonPresontoire::class);
    }

    // /**
    //  * @return RaisonPresontoire[] Returns an array of RaisonPresontoire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function raison()
    {
        return $this->createQueryBuilder('r')
            ->select('r.id','r.raison as label')
            ->getQuery()
            ->getResult()
            ;
    }


    public function findOneByid($value)
    {
        return $this->createQueryBuilder('r')
            ->select('r.id','r.raison as label')
            ->andWhere('r.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

}
