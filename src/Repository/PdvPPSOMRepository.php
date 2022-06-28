<?php

namespace App\Repository;

use App\Entity\PdvPPSOM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvPPSOM|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvPPSOM|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvPPSOM[]    findAll()
 * @method PdvPPSOM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvPPSOMRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvPPSOM::class);
    }

    // /**
    //  * @return PdvPPSOM[] Returns an array of PdvPPSOM objects
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
    public function pposm()
    {
        return $this->createQueryBuilder('c')

            ->select('c.id','c.ppsom as label')
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?PdvPPSOM
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
