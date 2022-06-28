<?php

namespace App\Repository;

use App\Entity\RapportPPOSM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RapportPPOSM|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportPPOSM|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportPPOSM[]    findAll()
 * @method RapportPPOSM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportPPOSMRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RapportPPOSM::class);
    }

    // /**
    //  * @return RapportPPOSM[] Returns an array of RapportPPOSM objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function PPOSM_Jti()
    {
        return $this->createQueryBuilder('r')
            ->select('r.id','r.label','r.image')
            ->andWhere('r.isJti = :1')
            ->getQuery()
            ->getResult()
            ;
    }
    /*
    public function findOneBySomeField($value): ?RapportPPOSM
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
