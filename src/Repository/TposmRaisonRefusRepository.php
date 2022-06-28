<?php

namespace App\Repository;

use App\Entity\TposmRaisonRefus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TposmRaisonRefus|null find($id, $lockMode = null, $lockVersion = null)
 * @method TposmRaisonRefus|null findOneBy(array $criteria, array $orderBy = null)
 * @method TposmRaisonRefus[]    findAll()
 * @method TposmRaisonRefus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TposmRaisonRefusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TposmRaisonRefus::class);
    }

    // /**
    //  * @return TposmRaisonRefus[] Returns an array of TposmRaisonRefus objects
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
    public function raison()
    {
        return $this->createQueryBuilder('t')
            ->select('t.id', 't.raison as label')
            ->getQuery()
            ->getResult();
    }
    /*
    public function findOneBySomeField($value): ?TposmRaisonRefus
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
