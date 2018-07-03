<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 16/06/18
 * Time: 12:10 PM
 */

namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Category;

use App\Entity\Product;

class CatalogController extends Controller
{
    /**
     * @Route("/cat", name="cat")
     */
    public function cat()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('catalog/shop.html.twig', compact('categories'));

    }

    /**
     * @Route("/products/{productid}", name="product")
    //     *@ParamConverter("product", options={"mapping" : {"productid" : "id"}})
     */
    public function product($productid)
    {
        $products = $this->getDoctrine()->getRepository(Product::class)
            ->findBy(['category' => $productid]);
        return $this->render('catalog/index.html.twig', compact('products')); //'catalog/shop.html.twig', compact('categories'));
    }
}