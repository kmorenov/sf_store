<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 6/08/18
 * Time: 9:42 PM
 */
namespace App\Service;
use App\Entity\Product;
use App\Repository\ProductRepository;


class CartManager
{
    const SESSION_CART_ID = 'cart';
    private $repository;


    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }
    public function add(Product $product, int $quantity)
    {
        if (isset($_SESSION[self::SESSION_CART_ID]) && isset($_SESSION[self::SESSION_CART_ID][$product->getId()])) {
            $_SESSION[self::SESSION_CART_ID][$product->getId()] += $quantity;
            return;
        }
        $_SESSION[self::SESSION_CART_ID][$product->getId()] = $quantity;
    }
    public function getCart() :array
    {
        $res = [];

        if (!isset($_SESSION[self::SESSION_CART_ID]) || empty($_SESSION[self::SESSION_CART_ID])) {
            return [];
        }
        foreach ($_SESSION[self::SESSION_CART_ID] as $productId => $quantity) {
            $position['quantity'] = $quantity;
            $position['product'] = $this->repository->find($productId);
            $res[] = $position;
        }

        return $res;
    }
}