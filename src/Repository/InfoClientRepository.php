<?php

namespace App\Repository;

use App\Entity\InfoClient;
use App\Entity\TypeClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InfoClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoClient[]    findAll()
 * @method InfoClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoClientRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InfoClient::class);
    }

    public function findinfClient($value)
    {
         $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('a.nom', 'a.telephone', 'a.situationFamil', 'a.nombreEnfants', 'a.age', 'tc.type')
            ->from('App\Entity\TypeClient', 'tc')
            ->innerJoin('App\Entity\InfoClient', 'a')
            ->andWhere('a.client = :val' )
            ->andWhere('a.typeClientNew= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }



    public function findModifinfClient($value)
    {
         $qb = $this->_em->createQueryBuilder();
        $result = $qb->select( 'tc.type' ,'a.nom', 'a.telephone')
            ->from('App\Entity\TypeClient', 'tc')
            ->innerJoin('App\Entity\InfoClient', 'a')
            ->andWhere('a.client = :val' )
            ->andWhere('a.typeClientNew= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    // /**
    //  * @return InfoClient[] Returns an array of InfoClient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InfoClient
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
