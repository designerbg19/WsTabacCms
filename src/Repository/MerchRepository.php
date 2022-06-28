<?php

namespace App\Repository;

use App\Entity\Merch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use App\Service\Params;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Merch|null find($id, $lockMode = null, $lockVersion = null)
 * @method Merch|null findOneBy(array $criteria, array $orderBy = null)
 * @method Merch[]    findAll()
 * @method Merch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MerchRepository extends ServiceEntityRepository
{


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Merch::class);
    }



     /**
      * @return Merch[] Returns an array of Merch objects
      */

    public function customFindAll()
    {
        $v= $_SERVER['HTTP_HOST'];
        //$h ="http://";
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
        return $this->createQueryBuilder('m')
            ->leftJoin('m.region','r')
            ->select("m.id",
                "m.code","m.firstName",
                "m.lastName","r.label as region",
                "r.id as regionId","CONCAT('$protocol','$v',m.pathImage) as image",
                "m.updatedAt","m.roles","CONCAT(m.code,'-',m.firstName,' ',m.lastName) as fullname"
            )
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * For BO to get = post attributes
     * @return Merch[] Returns an array of Merch objects
     */

    public function customFindById($value)
    {
        $v= $_SERVER['HTTP_HOST'];
        $h ="http://";
        return $this->createQueryBuilder('m')
            ->leftJoin('m.region','r')
            ->select("m.id",
                "m.code","m.firstName",
                "m.lastName","r.label as region",
                "r.id as regionId","CONCAT('$h','$v',m.pathImage) as image",
                "m.updatedAt","m.roles","CONCAT(m.code,'-',m.firstName,' ',m.lastName) as fullname"
            )
            ->andWhere('m.id = :val')
            ->setParameter('val',$value)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     * @return Merch[] Returns an array of Merch objects
     */

    public function customFind($value)
    {
        $v= $_SERVER['HTTP_HOST'];
        $h ="http://";
        return $this->createQueryBuilder('m')
            ->leftJoin('m.region','r')
            ->select("m.id",
                "m.code","m.firstName",
                "m.lastName","r.label as region",
                "r.id as regionId","CONCAT('$h','$v',m.pathImage) as image",
                "m.updatedAt","m.roles","CONCAT(m.code,'-',m.firstName,' ',m.lastName) as fullname"
            )
            ->where('m.id = :val')
            ->setParameter('val',$value)
            ->getQuery()
            ->getResult()
            ;
    }

    ///**
     //* @return Merch[] Returns an array of Merch objects
     //*/

  /*  public function customFind($value)
    {
        return $this->createQueryBuilder('m')
            ->join('m.region','r')
            ->join('m.file','f')
            ->select('m.id','m.code','m.firstName','m.lastName','r.label as region','f.label as image',
                'f.path','f.dateCreation','m.roles')
            ->where('m.id = :val')
            ->setParameter('val ',$value)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }*/

    /**
     * Function findAll Merchs with Pagination
     * @return Query
     */

    public function customFindAllQuery()
    {
        $v= $_SERVER['HTTP_HOST'];
        $h ="http://";
        return $this->createQueryBuilder('m')
            ->leftJoin('m.region','r')
            ->select("m.id",
                "m.code","m.firstName",
                "m.lastName","r.label as region",
                "r.id as regionId","CONCAT('$h','$v',m.pathImage) as image",
                "m.updatedAt","m.roles","CONCAT(m.code,'-',m.firstName,' ',m.lastName) as fullname"
            )
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ;
    }







    // /**
    //  * @return Merch[] Returns an array of Merch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Merch
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



}
