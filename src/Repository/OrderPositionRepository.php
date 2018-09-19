<?php

namespace App\Repository;

use App\Entity\OrderPosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OrderPosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderPosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderPosition[]    findAll()
 * @method OrderPosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderPositionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OrderPosition::class);
    }

//    /**
//     * @return OrderPosition[] Returns an array of OrderPosition objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderPosition
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
