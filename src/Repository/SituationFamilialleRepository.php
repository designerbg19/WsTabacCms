<?php

namespace App\Repository;

use App\Entity\SituationFamilialle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SituationFamilialle|null find($id, $lockMode = null, $lockVersion = null)
 * @method SituationFamilialle|null findOneBy(array $criteria, array $orderBy = null)
 * @method SituationFamilialle[]    findAll()
 * @method SituationFamilialle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SituationFamilialleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SituationFamilialle::class);
    }

    // /**
    //  * @return SituationFamilialle[] Returns an array of SituationFamilialle objects
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
    public function findSituation()
    {
        return $this->createQueryBuilder('s')
            ->select('s.id','s.sitation as label')
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?SituationFamilialle
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
