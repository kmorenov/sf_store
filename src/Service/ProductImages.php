<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 3/01/19
 * Time: 3:31 AM
 */

namespace App\Service;

use App\Repository\ProductImageRepository;

class ProductImages
{
    private $productImageRepository;

    public function __construct(ProductImageRepository $productImageRepository)
    {
        $this->productImageRepository = $productImageRepository;
    }

    public function getProductImages($id)
    {
        $dql = $this->productImageRepository->createQueryBuilder('i')
            ->andWhere('i.product = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return $dql;
    }
}