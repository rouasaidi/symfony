<?php

namespace App\Repository;

use App\Entity\FeedbackDon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FeedbackDon>
 *
 * @method FeedbackDon|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeedbackDon|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeedbackDon[]    findAll()
 * @method FeedbackDon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackDonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeedbackDon::class);
    }

//    /**
//     * @return FeedbackDon[] Returns an array of FeedbackDon objects
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

//    public function findOneBySomeField($value): ?FeedbackDon
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
