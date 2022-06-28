<?php

namespace App\Repository;

use App\Entity\PdvEmplacements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvEmplacements|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvEmplacements|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvEmplacements[]    findAll()
 * @method PdvEmplacements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvEmplacementsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvEmplacements::class);
    }

    // /**
    //  * @return PdvEmplacements[] Returns an array of PdvEmplacements objects
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
    public function findOneBySomeField($value): ?PdvEmplacements
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
