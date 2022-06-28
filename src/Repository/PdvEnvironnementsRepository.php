<?php

namespace App\Repository;

use App\Entity\PdvEnvironnements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvEnvironnements|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvEnvironnements|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvEnvironnements[]    findAll()
 * @method PdvEnvironnements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvEnvironnementsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvEnvironnements::class);
    }

    // /**
    //  * @return PdvEnvironnementsController[] Returns an array of PdvEnvironnementsController objects
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
    public function findOneBySomeField($value): ?PdvEnvironnementsController
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
