<?php

namespace App\Repository;

use App\Entity\Survey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Survey|null find($id, $lockMode = null, $lockVersion = null)
 * @method Survey|null findOneBy(array $criteria, array $orderBy = null)
 * @method Survey[]    findAll()
 * @method Survey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurveyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Survey::class);
    }



    /**
     *  Custom Find All : Get just the id , title , visibility of Survey
      * @return Survey[] Returns an array of Survey objects
     */

    public function customFindAll()
    {
        return $this->createQueryBuilder('s')
            ->select('s.id','s.title','s.visibility')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     *  Custom Find All : Get just the id , title , visibility of Survey
     * @return Survey[] Returns an array of Survey objects
     */

    public function customFindSurvey($value)
    {
        return $this->createQueryBuilder('s')
            ->select('s.id','s.title','s.visibility','s.cycle')
            ->andWhere('s.id = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     *  Custom Find All  : Get just the id , title , visibility of Survey with pagination
     * @return Query
     */

    public function customFindAllWithPagination()
    {
        return $this->createQueryBuilder('s')
            ->select('s.id','s.title','s.visibility')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ;
    }

    /**
     *  Custom Find  : Get some field of Survey
     * @return Survey[] Returns an array of Survey objects
     */

    public function customFind($value)
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.merch','m')
            ->join('s.surveyQuestions','sq')
            ->select(
                's.id','s.title','s.cycle as cycle_id')
            ->andWhere('s.id = :val')
            ->setParameter('val', $value)
            ->distinct(true)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }



    /**
     *  Custom Find  : Get some field of Survey
     * @return Survey[] Returns an array of Survey objects
     */

    public function customFindSurveyMerchs($value)
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.merch','m')
            ->select('m.id','CONCAT(m.code,\' - \',m.firstName,\' \',m.lastName) AS full_name')
            ->andWhere('s.id = :val')
            ->setParameter('val', $value)
            ->distinct(true)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


     /**
      * Find Survey By Cycle
      * @return Survey[] Returns an array of Survey objects
      */

    public function findSurveyByCycle($value)
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.merch','m')
            ->join('s.surveyQuestions','sq')
            ->select('s.id','s.title','sq.id as question_id','sq.questions','sq.formTypes','sq.options')
            ->andWhere('s.cycle like :val')
            ->andWhere('s.visibility = 1')
            ->setParameter('val', $value)
            ->andWhere('m.id is NULL')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Find Survey(sondage) and SurveyQuestions In Cycle By Merch
     * @return Survey[] Returns an array of Survey objects
     */

    public function findSurveyByMerch($value,$value2)
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.merch','m')
            ->join('s.surveyQuestions','sq')
            ->select('s.id','s.title','sq.id as question_id','sq.questions','sq.formTypes','sq.options')
            ->andWhere('m.id = :val')
            ->andWhere('s.cycle = :val2')
            ->andWhere('s.visibility = 1')
            ->setParameter('val', $value)
            ->setParameter('val2', $value2)
            ->getQuery()
            ->getResult()
            ;
    }



    // /**
    //  * @return Survey[] Returns an array of Survey objects
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
    public function findOneBySomeField($value): ?Survey
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
