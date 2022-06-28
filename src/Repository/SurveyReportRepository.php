<?php

namespace App\Repository;

use App\Entity\SurveyReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SurveyReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method SurveyReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method SurveyReport[]    findAll()
 * @method SurveyReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurveyReportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SurveyReport::class);
    }


     /**
      * @return SurveyReport[] Returns an array of SurveyReport objects
      */

    public function findAllSurveyReport($value)
    {
        return $this->createQueryBuilder('s')
            ->select('s')
            ->andWhere('s.surveyId = :val')
            ->setParameter('val',$value)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    // /**
    //  * @return SurveyReport[] Returns an array of SurveyReport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SurveyReport
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
