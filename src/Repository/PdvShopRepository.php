<?php

namespace App\Repository;

use App\Entity\PdvShop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvShop|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvShop|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvShop[]    findAll()
 * @method PdvShop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvShopRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvShop::class);
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
    /*
    public function shop()
    {
        return $this->createQueryBuilder('p')

            ->select('p.id','p.shop as label')
            ->getQuery()
            ->getResult()
            ;
    }
*/
    public function shop()
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select( 'p.id','p.shop as label','tc.path as image')
            ->from('App\Entity\PdvShop', 'p')
            ->innerJoin('App\Entity\File', 'tc')
            ->andWhere('tc.id=p.image')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function shop_id($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select( 'p.id','p.shop as label','tc.path as image')
            ->from('App\Entity\PdvShop', 'p')
            ->innerJoin('App\Entity\File', 'tc')
            ->andWhere('tc.id=p.image')
            ->andWhere('p.id=:val')
            ->setParameter('val', $id)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }
    /*
    public function findOneBySomeField($value): ?PdvShop
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * Bo
     * @return PdvShop[] Returns an array of PdvShop objects
     * @author youssef
     */
    public function findShopById($value)
    {
        $v= $_SERVER['HTTP_HOST'];
        //$h ="http://";
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
        return $this->createQueryBuilder('p')
            ->innerJoin('p.image','i')
            ->select("p.id","p.shop as label","CONCAT('$protocol','$v',i.path) as myFile")
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }


     /**
      * @return PdvShop[] Returns an array of PdvShop objects
      */

    public function findAllShopBo()
    {
        $v= $_SERVER['HTTP_HOST'];
        //$h ="http://";
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
        return $this->createQueryBuilder('p')
            ->innerJoin('p.image','i')
            ->select("p.id","p.shop as label","CONCAT('$protocol','$v',i.path) as myFile")
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
