<?php

namespace App\Repository;

use App\Entity\CommentaireType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommentaireType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireType[]    findAll()
 * @method CommentaireType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommentaireType::class);
    }

    // /**
    //  * @return CommentaireType[] Returns an array of CommentaireType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommentaireType
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
