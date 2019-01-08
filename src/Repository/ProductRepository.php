<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getProductsQuery(Category $category, Request $request)
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->join('p.category', 'cat')
            ->join('cat.parent', 'parent')
            ->andWhere('cat.name = :categoryName')
            ->setParameter('categoryName', $category->getName());

        //minPrice
        if ($minPrice = $request->get('minPrice')) {
            $qb
                ->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice', $minPrice);
        }

        //maxPrice
        if ($maxPrice = $request->get('maxPrice')) {
            $qb
                ->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        return $qb->getQuery();
    }

    public function getCategoriesBelowPaged($id, $request)
    {
        $dql = $this->createQueryBuilder('p')
            ->join('p.category', 'c')
//            ->addSelect('p')
            ->select('p.id, c.name, p.model, p.price')
            ->andWhere('c.parent = :id')
            ->setParameter('id', $id);
//            ->getQuery();

        if ($maxPrice = $request->get('maxPrice')) {
            $dql
                ->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        if ($minPrice = $request->get('minPrice')) {
            $dql
                ->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice', $minPrice);
        }

        if ($brand = $request->get('brand')) {
            $dql
                ->andWhere('c.name = :brand')
                ->setParameter('brand', $brand);
        }

        return $dql;
    }


//    /**
//     * @return Product[] Returns an array of Product objects
//     */
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

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
