<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

use Doctrine; //\ORM\EntityManager;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function getCategoriesBelow($id)
    {
        $dql = $this->createQueryBuilder('c')
            ->andWhere('c.parent = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return $dql;
    }

    public function getCategoriesBelowPaged($id)
    {
/*        $dql = "SELECT p.id, c.name, p.model, p.price
                FROM App\Entity\Category c
                JOIN App\Entity\Product p 
                WHERE c.id = p.category
                AND c.parent = $id";
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getResult();*/

        $dql = $this->createQueryBuilder('c')
            ->join('c.products', 'p')
            ->addSelect('p')
            ->select('p.id, c.name, p.model, p.price')
            ->andWhere('c.parent = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return $dql;
    }

/*    public function getCategoriesBelowQueryTEST($id)
    {
        $sql = "SELECT p.id, c.name, p.model, p.price
                FROM category c
                JOIN product p ON c.id = p.category_id
                WHERE c.parent_id = $id";
        $em = $this->getEntityManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();

    }*/

//    /**
//     * @return Category[] Returns an array of Category objects
//     */
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
    public function findOneBySomeField($value): ?Category
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
