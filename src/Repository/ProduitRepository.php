<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
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
    public function getbyId($value)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function produit()
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.typeproduit', 'tp')
            ->leftJoin('p.file', 'f')
            ->select('p.id', 'p.nom as label', 'tp.isJti', 'p.isVisible', 'tp.type', 'f.path as image')
            ->getQuery()
            ->getResult();
    }

    public function produitToStoke()
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.typeproduit', 'tp')
            ->select('p.id', 'p.nom as label')
            ->andWhere('tp.isJti = true')
            ->getQuery()
            ->getResult();
    }

    public function JTIid_stoke($value)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.stokes', 'st')
            ->select('st.id')
            ->andWhere('p.id =:val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function produitBONOtJTI()
    {
        $v = $_SERVER['HTTP_HOST'];
        //$h ="http://";
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
        return $this->createQueryBuilder('p')
            ->leftJoin('p.typeproduit', 'tp')
            ->leftJoin('p.file', 'f')
            ->select('p.id', 'p.nom as label', 'tp.type', 'p.color as codeCouleur',
                "CONCAT('$protocol','$v',f.path) as path", 'p.isVisible as is_visible')
            ->andWhere('tp.isJti= false')
            ->getQuery()
            ->getResult();
    }


    public function produitBONOtJTIAuto()
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.typeproduit', 'tp')
            ->leftJoin('p.file', 'f')
            ->select('p.id')
            ->andWhere('tp.isJti= true')
            ->getQuery()
            ->getResult();
    }

    public function produitIs_JTI($value)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.typeproduit', 't')
            ->select('t.isJti')
            ->andWhere('p.id =:val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function produitBOJTI()
    {
        $v = $_SERVER['HTTP_HOST'];
        //$h ="http://";
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
        return $this->createQueryBuilder('p')
            ->leftJoin('p.typeproduit', 'tp')
            ->leftJoin('p.file', 'f')
            ->select('p.id', 'p.nom as label', 'tp.type', 'p.color as codeCouleur',
                "CONCAT('$protocol','$v',f.path) as path", 'p.isVisible as is_visible')
            ->andWhere('tp.isJti= true')
            ->getQuery()
            ->getResult();
    }
    /*
    public function findOneBySomeField($value): ?Produit
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
     *  yo: BO
     * @return Produit[] Returns an array of Produit objects
     */

    public function findProduitBOById($value)
    {
        $v = $_SERVER['HTTP_HOST'];
        //$h ="http://";
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
        return $this->createQueryBuilder('p')
            ->leftJoin('p.typeproduit', 'tp')
            ->leftJoin('p.file', 'f')
            ->select('p.id', 'p.nom as label', 'tp.isJti', 'tp.type', 'p.color as codeCouleur',
                "CONCAT('$protocol','$v',f.path) as path")
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();;
    }

    /**
     * @return mixed
     * @author  youssef
     */
    public function produitBo()
    {
        $v = $_SERVER['HTTP_HOST'];
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
        return $this->createQueryBuilder('p')
            ->leftJoin('p.typeproduit', 'tp')
            ->leftJoin('p.file', 'f')
            ->select('p.id', 'p.nom as label', 'tp.isJti', 'p.isVisible', 'tp.type',
                "CONCAT('$protocol','$v',f.path) as path")
            ->getQuery()
            ->getResult();
    }
}
