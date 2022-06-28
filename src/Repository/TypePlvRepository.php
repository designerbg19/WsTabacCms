<?php

namespace App\Repository;

use App\Entity\TypePlv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypePlv|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypePlv|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypePlv[]    findAll()
 * @method TypePlv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypePlvRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypePlv::class);
    }

    // /**
    //  * @return TypePlv[] Returns an array of TypePlv objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function type()
    {
        return $this->createQueryBuilder('t')

            ->select('t.id','t.type as label')
            ->getQuery()
            ->getResult()
            ;
    }


    public function typePLV_id($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select( 'p.id','p.type as label')
            ->from('App\Entity\TypePlv', 'p')
            ->andWhere('p.id=:val')
            ->setParameter('val', $id)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }
    /*
    public function findOneBySomeField($value): ?TypePlv
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
