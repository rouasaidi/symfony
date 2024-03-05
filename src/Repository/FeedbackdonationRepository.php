<?php

namespace App\Repository;

use App\Entity\Feedbackdonation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Feedbackdonation>
 *
 * @method Feedbackdonation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feedbackdonation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feedbackdonation[]    findAll()
 * @method Feedbackdonation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackdonationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feedbackdonation::class);
    }

//    /**
//     * @return Feedbackdonation[] Returns an array of Feedbackdonation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Feedbackdonation
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
