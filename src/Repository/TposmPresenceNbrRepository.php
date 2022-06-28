<?php

namespace App\Repository;

use App\Entity\TposmPresenceNbr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TposmPresenceNbr|null find($id, $lockMode = null, $lockVersion = null)
 * @method TposmPresenceNbr|null findOneBy(array $criteria, array $orderBy = null)
 * @method TposmPresenceNbr[]    findAll()
 * @method TposmPresenceNbr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TposmPresenceNbrRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TposmPresenceNbr::class);
    }

    // /**
    //  * @return TposmPresenceNbr[] Returns an array of TposmPresenceNbr objects
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
    public function nbr()
    {
        return $this->createQueryBuilder('t')
            ->select('t.id', 't.nbrArticle as label')
            ->getQuery()
            ->getResult();
    }
    /*
    public function findOneBySomeField($value): ?TposmPresenceNbr
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
