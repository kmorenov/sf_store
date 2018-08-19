<?php
namespace App\Controller;
use App\Entity\Product;
use App\Service\CartManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Repository\ProductRepository;

class CartController extends Controller
{
    public $session;
    /**
     * @Route("/cart", name="cart")
     */
    public function index()
    {
        $cm = $this->get(CartManager::class);
        return $this->render('cart/index.html.twig', ['cart' => $cm->getCart()]);
    }
    /**
     * @Route("/add-to-cart/{product}", name="add_to_cart")
     */
    public function add(Product $product, Request $request)
    {
        $cm = $this->get(CartManager::class);
        $cm->add($product, $request->get('quantity'));
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