<?php
namespace App\Controller;
use App\Entity\Product;
//use App\Service\CartManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Repository\ProductRepository;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends Controller
{
    const SESSION_CART_ID = 'cart';
    private $repository;
    private $session;

    public function __construct(ProductRepository $repository, SessionInterface $session)
    {
        $this->repository = $repository;
        $this->session = $session;
    }

    public function add(Product $product, int $quantity)
    {
        $cart = $this->session->get(self::SESSION_CART_ID);

        if ($this->session->has(self::SESSION_CART_ID) && isset($cart[$product->getId()])) {
            $cart[$product->getId()] += $quantity;
//            $this->session->set(self::SESSION_CART_ID, $cart);
//            return;
        }else {
            $cart[$product->getId()] = $quantity;
        }
        $this->session->set(self::SESSION_CART_ID, $cart);

/*        if (isset($_SESSION[self::SESSION_CART_ID]) && isset($_SESSION[self::SESSION_CART_ID][$product->getId()])) {
            $_SESSION[self::SESSION_CART_ID][$product->getId()] += $quantity;
            return;
        }
        $_SESSION[self::SESSION_CART_ID][$product->getId()] = $quantity;*/
    }

    public function getCart() :array
    {
        $res = [];

//        if (!isset($_SESSION[self::SESSION_CART_ID]) || empty($_SESSION[self::SESSION_CART_ID])) {
        if (!$this->session->has(self::SESSION_CART_ID) || empty($this->session->has(self::SESSION_CART_ID))){
            return [];
        }
//        foreach ($_SESSION[self::SESSION_CART_ID] as $productId => $quantity) {
        foreach ($this->session->get(self::SESSION_CART_ID) as $productId => $quantity) {
            $position['quantity'] = $quantity;
            $position['product'] = $this->repository->find($productId);
            $res[] = $position;
        }

        return $res;
    }

    /**
     * @Route("/cart", name="cart")
     */
    public function index()
    {
//        $cm = $this->get(CartManager::class);
        return $this->render('cart/index.html.twig', ['cart' => $this->getCart()]);
    }

    /**
     * @Route("/remove-from-cart/{product}", name="remove_from_cart")
    */
    public function remove(Product $product)
    {
        $cart = $this->session->get(self::SESSION_CART_ID);
        if (array_key_exists($product->getId(), $cart)){ //$_SESSION['cart'])) {
            unset($cart[$product->getId()]);
            $this->session->set(self::SESSION_CART_ID, $cart);
        }
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/empty-cart/", name="empty_cart")
     */
    public function emptyCart()
    {
//        unset($_SESSION[self::SESSION_CART_ID]);
        $this->session->remove(self::SESSION_CART_ID);
        return $this->redirectToRoute('category');
    }

    /**
     * @Route("/add-to-cart/{product}", name="add_to_cart")
     */
    public function add2(Product $product, Request $request)
    {
//        $cm = $this->get(CartManager::class);
        $this->add($product, $request->get('quantity'));
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/article/{productid}", name="article")
    //     * @ParamConverter("product", options={"mapping": {"productid": "id"}})
     */
    public function article(ProductRepository $productRepository, $productid)
    {
        $product = $productRepository->findOneBy(['id' => $productid]);
        return $this->render('main/article.html.twig', [
            'product' => $product,
        ]);
    }
}