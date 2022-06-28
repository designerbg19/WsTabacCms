<?php

namespace App\Repository;

use App\Entity\TposmInstalationNbr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TposmInstalationNbr|null find($id, $lockMode = null, $lockVersion = null)
 * @method TposmInstalationNbr|null findOneBy(array $criteria, array $orderBy = null)
 * @method TposmInstalationNbr[]    findAll()
 * @method TposmInstalationNbr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TposmInstalationNbrRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TposmInstalationNbr::class);
    }

    // /**
    //  * @return TposmInstalationNbr[] Returns an array of TposmInstalationNbr objects
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
    public function inst()
    {
        return $this->createQueryBuilder('t')
            ->select('t.id', 't.nbrArticle as label')
            ->getQuery()
            ->getResult();
    }
    /*
    public function findOneBySomeField($value): ?TposmInstalationNbr
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
