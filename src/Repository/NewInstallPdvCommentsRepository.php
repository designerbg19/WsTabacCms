<?php

namespace App\Repository;

use App\Entity\NewInstallPdvComments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NewInstallPdvComments|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewInstallPdvComments|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewInstallPdvComments[]    findAll()
 * @method NewInstallPdvComments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewInstallPdvCommentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NewInstallPdvComments::class);
    }


     /**
      * @return NewInstallPdvCommentsController[] Returns an array of NewInstallPdvCommentsController objects
      */

    public function customFind($value)
    {
        $v= $_SERVER['HTTP_HOST'];
        //$h ="http://";
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
        return $this->createQueryBuilder('n')
            ->select("n.id as commentId","n.comment","CONCAT('$protocol','$v',n.modifiedImage) as image")
            ->andWhere('n.newInstallPdv = :val')
            ->setParameter('val', $value)
            ->setMaxResults(1)
            ->orderBy('n.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }




    // /**
    //  * @return NewInstallPdvCommentsController[] Returns an array of NewInstallPdvCommentsController objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewInstallPdvCommentsController
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
