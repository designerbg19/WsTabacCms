<?php

namespace App\Repository;

use App\Entity\Routing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Routing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Routing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Routing[]    findAll()
 * @method Routing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoutingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Routing::class);
    }


    /**
     * @return Routing[] Returns an array of Routing objects
     */
    public function customFindRoutingById($value)
    {
        $theRouting =array('routing'=>$this->findTheRouting($value));
        $allClientsInTheRouting = array('clients'=> $this->findAllClientsInRouting($value));

        return  array_merge($theRouting, $allClientsInTheRouting);
    }


    /**
     * Find All Clients In Routing
     * @return Routing[] Returns an array of Routing objects
     */
    public function findAllClientsInRouting($value)
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.clients','c')
            ->select('c.id as ClientId','c.codeClient')
            ->andWhere('r.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     * Find The Routing
     * @return Routing[] Returns an array of Routing objects
     */
    public function findTheRouting($value)
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.zone','z')
            ->select('r.id','CONCAT (r.classe,\' \' ,r.codeRouting,\' \' ,r.ville) as classCodeVille','r.classe','r.codeRouting as code_routing','r.ville','r.information','r.nbrsPdv as posNumbers','z.label as zone','z.id as zone_id','r.merch')
            ->andWhere('r.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }



    /**
     * Custom Find All Routing
     * @return Routing[] Returns an array of Routing objects
     */
    public function customFindAllRouting()
    {
        $query = $this->createQueryBuilder('r')
            ->leftJoin('r.zone','z')
            ->select('r.id','CONCAT (r.classe,\' \' ,r.codeRouting,\' \' ,r.ville) as classCodeVille',
                'r.information','r.nbrsPdv as posNumbers','r.merch','z.label as zone')
            ->orderBy('r.codeRouting')
            ->getQuery()
            ->getResult()
            ;
        return $query;
    }

    /**
     * Function Custom Find All Routing with Pagination
     * @return Query Returns an array of Routing objects
     */
    public function customFindAllRoutingQuery()
    {
        return $query = $this->createQueryBuilder('r')
            ->leftJoin('r.zone','z')
            ->select('r.id','CONCAT (r.classe,\' \' ,r.codeRouting,\' \' ,r.ville) as classCodeVille',
                'r.information','r.nbrsPdv as posNumbers','r.merch','z.label as zone')
            ->getQuery()
            ;

    }

     /**
      * isDraft = 0 (means that get all client not draft)
      * @return Routing[] Returns an array of Routing objects
      */

    public function findAllClientInRoutingA($value)
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.clients','c')
            ->leftJoin('c.infoClient','ic')
            ->leftJoin('ic.typeClientNew','tc')
            ->leftJoin('c.classe','cl')
            //->select('r.id','r.classe','r.codeRouting','r.ville','c.id as ClientId')
            ->select('c.id as clientId','c.codeClient','ic.nom as nom_titulaire','cl.label as classe','c.isTlp as tlp','c.latitude','c.longitude')
            ->andWhere('r.id = :val')
            ->setParameter('val', $value)
            ->andWhere('tc.type like :val2')
            ->setParameter('val2','Titulaire')
            ->andWhere('c.draft = :val3')
            ->setParameter('val3',0)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Routing[] Returns an array of Routing objects
     */

    public function findAllClientInRoutingAm($value)
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.clients','c')
            ->leftJoin('c.infoClient','ic')
            ->leftJoin('ic.typeClientNew','tc')
            ->leftJoin('c.classe','cl')
            //->select('r.id','r.classe','r.codeRouting','r.ville','c.id as ClientId')
            ->select('c.id as clientId','c.codeClient','ic.nom as nom_titulaire','cl.label as classe','c.isTlp as tlp','c.latitude','c.longitude')
            ->andWhere('r.id = :val')
            ->setParameter('val', $value)
            ->andWhere('tc.type like :val2')
            ->setParameter('val2','Titulaire')
           ->andWhere('c.draft = :val3')
            ->setParameter('val3',0)
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     * @return Routing[] Returns an array of Routing objects
     */
    public function findAllClientInRoutingAAm($value,$value2)
    {
        $a = $this->findAllClientInRoutingA($value);
        $am = $this->findAllClientInRoutingAm($value2);

        return array_merge($a, $am);
    }



    // /**
    //  * @return Routing[] Returns an array of Routing objects
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

    /*
    public function findOneBySomeField($value): ?Routing
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * @return Routing[] Returns an array of Routing objects
     */

    public function findAllClientInRoutingAToVisiting($value)
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.clients','c')
            ->leftJoin('c.infoClient','ic')
            ->leftJoin('ic.typeClientNew','tc')
            ->leftJoin('c.classe','cl')
            //->select('r.id','r.classe','r.codeRouting','r.ville','c.id as ClientId')
            ->select('c.id as clientId','c.codeClient','ic.nom as nom_titulaire','cl.label as classe','c.isTlp as tlp','c.latitude','c.longitude')
            ->andWhere('r.id = :val')
            ->setParameter('val', $value)
            ->andWhere('tc.type like :val2')
            ->setParameter('val2','Titulaire')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Routing[] Returns an array of Routing objects
     */

    public function findAllClientInRoutingAmToVisiting($value)
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.clients','c')
            ->leftJoin('c.infoClient','ic')
            ->leftJoin('ic.typeClientNew','tc')
            ->leftJoin('c.classe','cl')
            //->select('r.id','r.classe','r.codeRouting','r.ville','c.id as ClientId')
            ->select('c.id as clientId','c.codeClient','ic.nom as nom_titulaire','cl.label as classe','c.isTlp as tlp','c.latitude','c.longitude')
            ->andWhere('r.id = :val')
            ->setParameter('val', $value)
            ->andWhere('tc.type like :val2')
            ->setParameter('val2','Titulaire')
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     * @return Routing[] Returns an array of Routing objects
     */
    public function findAllClientInRoutingAAmToVisiting($value,$value2)
    {
        $a = $this->findAllClientInRoutingAToVisiting($value);
        $am = $this->findAllClientInRoutingAmToVisiting($value2);

        return array_merge($a, $am);
    }
}
