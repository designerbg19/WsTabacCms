<?php

namespace App\Repository;

use App\Entity\PdvVisibilite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvVisibilite|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvVisibilite|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvVisibilite[]    findAll()
 * @method PdvVisibilite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvVisibiliteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvVisibilite::class);
    }

    // /**
    //  * @return PdvVisibilite[] Returns an array of PdvVisibilite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PdvVisibilite
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
