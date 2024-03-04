<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByExampleField($value): void
{
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
}
public function findByTotalPrix()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.total_prix', 'DESC')
        ->getQuery()
        ->getResult();
}
public function findByTotalPrixAsc()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.total_prix', 'ASC')
        ->getQuery()
        ->getResult();
}
public function countVipTicketsByEventId(int $eventId): int
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
            SELECT COUNT(t)
            FROM App\Entity\Ticket t
            WHERE t.event = :eventId
            AND t.type = :vipType
        ')
        ->setParameter('eventId', $eventId)
        ->setParameter('vipType', 'VIP');

        return $query->getSingleScalarResult();
    }
}
