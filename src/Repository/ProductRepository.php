<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function getPaginatedProducts($page, $limit, $filters = null)
    {
        $query = $this->createQueryBuilder('p');


        // On filtre les données
        if ($filters != null) {
            $query->andWhere('p.categories IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }

        $query->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit);
        return $query->getQuery()->getResult();
    }
    public function getPaginatedProduits( $page, $limit,$filters = null){
        $query = $this->createQueryBuilder('p');
            

        // On filtre les données
        if($filters != null){
            $query->andWhere('p.categories IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }

        $query->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit);
        return $query->getQuery()->getResult();
    }

    public function getTotalProduits($filters = null){
        $query = $this->createQueryBuilder('p')
            ->select('COUNT(p)');
            
        // On filtre les données
        if($filters != null){
            $query->andWhere('p.categories IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }

        return $query->getQuery()->getSingleScalarResult();
    }
    public function findPaginated($limit, $offset)
    {
        return $this->createQueryBuilder('u')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function FindBestALLTimeSellers(){
        return $this->createQueryBuilder('c')
            ->orderBy('c.totalsales', 'DESC')
            ->getQuery()
            ->setMaxResults(8)
            ->getResult();
    }
   
    public function FilterbyPriceDown(){
        return $this->createQueryBuilder('c')
            ->orderBy('c.price', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function FilterbyPriceUp(){
        return $this->createQueryBuilder('c')
            ->orderBy('c.price', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
