<?php

namespace App\Repository;

use App\Entity\SurveyQuestions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SurveyQuestions|null find($id, $lockMode = null, $lockVersion = null)
 * @method SurveyQuestions|null findOneBy(array $criteria, array $orderBy = null)
 * @method SurveyQuestions[]    findAll()
 * @method SurveyQuestions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurveyQuestionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SurveyQuestions::class);
    }


     /**
      * function to get all Question related to Survey ID
     * @return SurveyQuestions[] Returns an array of SurveyQuestions objects
      */

    public function findAllQuestionOfSurvey($value)
    {
        return $this->createQueryBuilder('s')
            ->join('s.survey','sur')
            ->andWhere('sur.id = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * function to get all Question related to Survey ID
     * @return SurveyQuestions[] Returns an array of SurveyQuestions objects
     */

    public function findCustomQuestionOfSurvey($value)
    {
        return $this->createQueryBuilder('s')
            ->join('s.survey','sur')
            ->select('s.id','s.questions','s.formTypes','s.options')
            ->andWhere('sur.id = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


    // /**
    //  * @return SurveyQuestions[] Returns an array of SurveyQuestions objects
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
    public function findOneBySomeField($value): ?SurveyQuestions
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
