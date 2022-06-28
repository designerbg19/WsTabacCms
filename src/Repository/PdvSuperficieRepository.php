<?php

namespace App\Repository;

use App\Entity\PdvSuperficie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvSuperficie|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvSuperficie|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvSuperficie[]    findAll()
 * @method PdvSuperficie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvSuperficieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvSuperficie::class);
    }

    // /**
    //  * @return PdvSuperficie[] Returns an array of PdvSuperficie objects
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
    public function findOneBySomeField($value): ?PdvSuperficie
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
