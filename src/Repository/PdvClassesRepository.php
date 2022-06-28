<?php

namespace App\Repository;

use App\Entity\PdvClasses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvClasses|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvClasses|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvClasses[]    findAll()
 * @method PdvClasses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvClassesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvClasses::class);
    }

    // /**
    //  * @return PdvClasses[] Returns an array of PdvClasses objects
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
    public function findOneBySomeField($value): ?PdvClasses
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
