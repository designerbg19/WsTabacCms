<?php

namespace App\Repository;

use App\Entity\PdvTPOSM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PdvTPOSM|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdvTPOSM|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdvTPOSM[]    findAll()
 * @method PdvTPOSM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdvTPOSMRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PdvTPOSM::class);
    }

    // /**
    //  * @return PdvTPOSM[] Returns an array of PdvTPOSM objects
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
    public function tposm()
    {
        return $this->createQueryBuilder('p')
            ->select('p.id', 'p.nom as label')
            ->getQuery()
            ->getResult();
    }

    public function tposmBO()
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.image','pd')
            ->select('p.id', 'p.nom as label','pd.path as myFile')
            ->getQuery()
            ->getResult();
    }


    public function PdvTPOSM_id($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select( 'p.id','p.nom as label')
            ->from('App\Entity\PdvTPOSM', 'p')
            ->andWhere('p.id=:val')
            ->setParameter('val', $id)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }
    /*
    public function findOneBySomeField($value): ?PdvTPOSM
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
     * @return PdvTPOSM[] Returns an array of PdvTPOSM objects
     */
    public function findTposmById($value)
    {
        $v= $_SERVER['HTTP_HOST'];
        //$h ="http://";
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
        return $this->createQueryBuilder('p')
            ->innerJoin('p.image','i')
            ->select("p.id","p.nom as label","CONCAT('$protocol','$v',i.path) as myFile")
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }
}
