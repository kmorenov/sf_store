<?php
namespace App\Controller;
use App\Entity\Orders;
use App\Entity\Product;
use App\Form\OrderType;
use App\Service\CartManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Repository\ProductRepository;


class CartController extends Controller
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index()
    {
        $cm = $this->get(CartManager::class);
        $order = new Orders();
        $orderForm = $this->createForm(OrderType::class, $order);
        return $this->render('cart/index.html.twig', ['cart' => $cm->getCart(), 'orderForm' => $orderForm->createView()]);
    }

    /**
     * @Route("/remove-from-cart/{product}", name="remove_from_cart")
    */
    public function remove(Product $product, Request $request)
    {
        $arr = json_decode($request->getContent(), true);

        $cm = $this->get(CartManager::class);
        $cm->remove($product);

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'error' => false,
                'total' => $cm->getTotal()
            ]);
        }

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/empty-cart/", name="empty_cart")
     */
    public function emptyCart(Request $request)
    {
        $referer = $request->headers->get('referer');
//        unset($_SESSION[self::SESSION_CART_ID]);
        $cm = $this->get(CartManager::class);
        $cm->emptyCart();
        return $this->redirect($referer); //'category');
    }

    /**
     * @Route("/add-to-cart/{product}", name="add_to_cart")
     */
    public function add2(Product $product, Request $request)
    {
        $cm = $this->get(CartManager::class);
        $cm->add($product, $request->get('quantity'));
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/article/{productid}", name="article")
     * @ParamConverter("product", options={"mapping": {"productid": "id"}})
     */
    public function article(Product $product) //ProductRepository $productRepository, $productid)
    {
//        $product = $productRepository->findOneBy(['id' => $productid]);
        return $this->render('main/article.html.twig', [
            'product' => $product,
        ]);
    }
}