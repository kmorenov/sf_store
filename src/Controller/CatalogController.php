<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 16/06/18
 * Time: 12:10 PM
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Category;

use App\Entity\Product;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Session\Session;


class CatalogController extends Controller
{
    public $cart;
    /**
     * @Route("/cat", name="category")
     */
    public function cat()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        dump($categories);
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

        return $this->render('catalog/index.html.twig', compact('products'));
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
/*        $request = Request::createFromGlobals();
        dump($request);
        $product = $this->getDoctrine()->getRepository(Product::class)->findBy(['id' => $id]);*/
        $this->add_to_cart($request);
        dump($this->cart);
        dump($request);
        return $this->render('cart/order.html.twig', ['cart' => $this->cart]); //'request')); //'product'));
    }

    /*
     * @Route("/cart", name="cart")
     */
    public function cart(Request $request)
    {
        $this->add_to_cart($request);
        dump($this->cart);

        return $this->render('cart/cart.html.twig', ['cart' => $this->cart]);
//        return $this->render('cart/cart.html.twig', compact('cart'));
//        return $this->render('cart/order.html.twig', compact('cart'));
    }


    private function add_to_cart($request)  //Request $request)
    {
        $session = $this->get('session');
        $cart = $session->get('cart');

        dump($cart);
        dump($request->get('productid'));
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

}