<?php

namespace App\Repository;

use App\Entity\PdvPresentoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvPresentoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvPresentoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvPresentoire[]    findAll()
 * @method PdvPresentoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvPresentoireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvPresentoire::class);
    }

    // /**
    //  * @return PdvPresentoire[] Returns an array of PdvPresentoire objects
    //  */

    /* public function findprsentoireJti()
     {
         return $this->createQueryBuilder('p')
             ->select('p.id', 'p.label','p.isJti as is_jti ')
             ->andWhere('p.isJti = true')
             ->orderBy('p.id', 'ASC')
             ->setMaxResults(20)
             ->getQuery()
             ->getResult()
         ;
     }*/
    public function findprsentoireJtiBO()
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('a.id', 'a.label as nom', 'tc.path as photo')
            ->from('App\Entity\PdvPresentoire', 'a')
            ->innerJoin('App\Entity\File', 'tc')
            ->andWhere('tc.id=a.image')
            ->andWhere('a.isJti = true')
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findprsentoireJti()
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('a.id', 'a.label', 'a.isJti as is_jti ', 'tc.path as image')
            ->from('App\Entity\PdvPresentoire', 'a')
            ->innerJoin('App\Entity\File', 'tc')
            ->andWhere('tc.id=a.image')
            ->andWhere('a.isJti = true')
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findprsentoireNotJti()
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('a.id', 'a.label', 'a.isJti as is_jti ', 'tc.path as image')
            ->from('App\Entity\PdvPresentoire', 'a')
            ->innerJoin('App\Entity\File', 'tc')
            ->andWhere('tc.id=a.image')
            ->andWhere('a.isJti = false')
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }


    /*
    public function findOneBySomeField($value): ?PdvPresentoire
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;findById
    }
    */

    /**
     * @return PdvPresentoire[] Returns an array of PdvPresentoire objects
     */
    public function findById($value)
    {
        $v = $_SERVER['HTTP_HOST'];
        //$h ="http://";
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
        return $this->createQueryBuilder('p')
            ->leftJoin('p.image', 'i')
            ->select("p.id", "p.label as label", "p.isJti as isJti", "CONCAT('$protocol','$v',i.path) as myFile")
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }


    /**
     * @param $value
     * @return mixed
     * @author youssef
     */
    public function findPresontoireJtiOrNotJti(bool  $value)
    {
        $v = $_SERVER['HTTP_HOST'];
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
        return $this->createQueryBuilder('p')
            ->leftJoin('p.image', 'i')
            ->leftJoin('p.maisonMaire', 'm')
            ->select("p.id", "p.label as label", "p.isJti as isJti", "CONCAT('$protocol','$v',i.path) as myFile" , 'm.id as maison')
            ->andWhere('p.isJti = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();

    }

    // /**
    //  * @return PdvShop[] Returns an array of PdvShop objects
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
}
