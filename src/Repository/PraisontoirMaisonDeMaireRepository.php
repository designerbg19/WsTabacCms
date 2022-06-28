<?php

namespace App\Repository;

use App\Entity\PraisontoirMaisonDeMaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PraisontoirMaisonDeMaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method PraisontoirMaisonDeMaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method PraisontoirMaisonDeMaire[]    findAll()
 * @method PraisontoirMaisonDeMaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PraisontoirMaisonDeMaireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PraisontoirMaisonDeMaire::class);
    }

    // /**
    //  * @return PraisontoirMaisonDeMaire[] Returns an array of PraisontoirMaisonDeMaire objects
    //  */

    public function PraisontoirMaisonDeMaireShowALL()
    {
        return $this->createQueryBuilder('p')
            ->select('p.id','p.maisonDeMaire as maison')
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function PraisontoirMaisonDeMaireShowALLBO()
    {
        return $this->createQueryBuilder('p')
            ->select('p.id','p.maisonDeMaire  as label')
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByid($id)
    {
        return $this->createQueryBuilder('p')
            ->select('p.id','p.maisonDeMaire as maison')
            ->andWhere('p.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
            ;
    }
    /*
    public function findOneBySomeField($value): ?PraisontoirMaisonDeMaire
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
