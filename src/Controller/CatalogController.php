<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 16/06/18
 * Time: 12:10 PM
 */

namespace App\Controller;

use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Category;

use App\Entity\Product;

use Symfony\Component\HttpFoundation\Request;

use App\Repository\CategoryRepository;

class CatalogController extends Controller
{
    public $cart;
    /**
     * @Route("/cat", name="category")
     */
    public function cat()
    {

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('catalog/shop.html.twig', compact('categories'));
    }

    /**
     * @Route("/products/{category}", name="product")
//     *@ParamConverter("product", options={"mapping" : {"category" : "id"}})
     */
    public function product(Category $category, ProductRepository $productRepository, Request $request)
    {
        $query = $productRepository->getProductsQuery($category, $request);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );

        $pagination->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        return $this->render('catalog/index.html.twig', compact('pagination'));
    }

    /**
     * @Route("/catalog/{id}", name="catalog")
     */
    public function catalog($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['id' => $id]);

        $session = $this->get('session');

        $cart = $session->get('cart', []);

        $newitem = false;
        if ($cart == null) {
            $newitem = true;
        }

        if (!$newitem) {
            for ($i=0; $i<count($cart); $i++) {
                if ($product->getId() == $cart[$i]['id']) {
                    $newitem = false;
                    break;
                }
                $newitem = true;
            }
        }

        if ($newitem) {
            if (!$cart) $cart = [];
            dump($product->getId());
            array_push($cart, [
                'id' => $product->getId(),
                'model' => $product->getModel(),
                'price' => $product->getPrice(),
                'quantity' => 1
            ]);

            $session->set('cart', $cart);
        }

        return $this->render('cart/cart.html.twig', compact('cart'));
    }

    /**
     * @Route("/order", name="order")
     */
    public function ordered(Request $request)
    {
//        $request = Request::createFromGlobals();
        $this->add_to_cart($request);
        return $this->render('cart/order.html.twig', ['cart' => $this->cart]); //'request')); //'product'));
    }

    /*
     * @Route("/cart", name="cart")
     */
    public function cart(Request $request)
    {
        $this->add_to_cart($request);
        return $this->render('cart/cart.html.twig', ['cart' => $this->cart]);
    }


    private function add_to_cart($request)  //Request $request)
    {
        $session = $this->get('session');
        $cart = $session->get('cart');

        if ($cart){ // && $request->get('quantity')){
            for ($i = 0; $i < count($cart); $i++) {
                if ($cart[$i]['id'] == $request->get('productid')) {
                    echo 'Matched';
                    if (array_key_exists('quantity', $cart[$i])) {
                        if ($cart[$i]['quantity'] != $request->get('quantity')) {
                            $cart[$i]['quantity'] = $request->get('quantity');
                            break;
                        }
                    }else{
                        $cart[$i] += ['quantity' => $request->get('quantity')];
                        break;
                    }
                }
            }
        }

//        if ($cart && isset($cart[$request->get('productid')])) {cd
//            $cart[$request->get('productid')] += $request->get('quantity');
//        } else {
//            $cart[$request->get('productid')] = $request->get('quantity');
//
//        }

        $session->set('cart', $cart);
        return $this->cart = $cart;
    }

    /**
     * @Route("/selected-category/{id}", name="selected_category")
     */
    public function getSelectedCategory(CategoryRepository $categoryRepository, $id)
    {
        $categories = $categoryRepository->getCategoriesBelow($id); //findBy(['parent' => $id]);
        $selectedCategory = $categoryRepository->findOneBy(['id' => $id]);
        return $this->render('catalog/selected_category.html.twig',
            ['categories' => $categories, 'id' => $id,
            'selectedCategory' => $selectedCategory]);
    }

    /**
     * @Route("/selected-category-paged/{id}", name="selected_category_paged")
     */
    public function getSelectedCategoryPaged(CategoryRepository $categoryRepository, $id, Request $request)
    {
        $query = $categoryRepository->getCategoriesBelowPaged($id);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );

        // parameters to template
        $pagination->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        $selectedCategory = $categoryRepository->findOneBy(['id' => $id]);
        return $this->render('catalog/selected_category_paged.html.twig',
            ['pagination' => $pagination,
                'id' => $id,
                'selectedCategory' => $selectedCategory,]);
    }
}