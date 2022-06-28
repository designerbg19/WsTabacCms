<?php

namespace App\Repository;

use App\Entity\NbrEnfant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NbrEnfant|null find($id, $lockMode = null, $lockVersion = null)
 * @method NbrEnfant|null findOneBy(array $criteria, array $orderBy = null)
 * @method NbrEnfant[]    findAll()
 * @method NbrEnfant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NbrEnfantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NbrEnfant::class);
    }

    // /**
    //  * @return NbrEnfant[] Returns an array of NbrEnfant objects
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
    public function findnbEnf()
    {
        return $this->createQueryBuilder('n')
            ->select('n.id','n.nbrEnfant as label')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?NbrEnfant
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
