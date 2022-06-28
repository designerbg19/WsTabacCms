<?php

namespace App\Repository;

use App\Entity\MarketingRecette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MarketingRecette|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketingRecette|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketingRecette[]    findAll()
 * @method MarketingRecette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketingRecetteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MarketingRecette::class);
    }

    // /**
    //  * @return MarketingRecette[] Returns an array of MarketingRecette objects
    //  */

    public function findMark()
    {
        return $this->createQueryBuilder('m')
            ->select('m.id','m.recetteList as label')
            ->getQuery()
            ->getResult();
    }




    public function findMarkby($value)
    {
        return $this->createQueryBuilder('m')
            ->select('m.id','m.recetteList as label')
            ->andWhere('m.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

}
