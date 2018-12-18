<?php

namespace App\Controller;

use App\Entity\OrderPosition;
use App\Entity\Orders;
use App\Service\CartManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Tests\Controller;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Form\OrderPositionType;

use App\Repository\ProductRepository;


class OrderController extends AbstractController
{
    private $formFactory;
    private $entityManager;
    private $cartManager;
    private $session;

    const SESSION_CART_ID = 'cart';

    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        CartManager $cartManager,
        SessionInterface $session,
        ProductRepository $productRepository
    )
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->cartManager = $cartManager;
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/order", name="order")
     */
    public function index(Request $request)
    {
        $order = new Orders();
        $orderForm = $this->formFactory->create(OrderType::class, $order);
        $orderForm->handleRequest($request);


        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $order = $orderForm->getData();

            if ($order instanceof Orders) {

                $this->entityManager->persist($order);
                $this->entityManager->flush();

                $session = $this->get('session');
                $cart = $session->get(self::SESSION_CART_ID);
                dump($cart);
                dump(key($cart));

                foreach ($cart as $key => $value) {
                    $orderPosition = new OrderPosition($this->productRepository->find($key)->getPrice(), $value, $key, $order);
                    $orderPositionForm = $this->formFactory->create(OrderPositionType::class, $orderPosition);
                    $orderPositionForm->handleRequest($request);
                    $orderPosition = $orderPositionForm->getData();
                    $this->entityManager->persist($orderPosition);

                $this->entityManager->flush();
                }

                $this->cartManager->emptyCart();


                $type = 'success';
                $message = 'Your order has been submitted.';
            } else {
                $type = 'error';
                $message = 'Your order could NOT be submitted.';
            }

            $this->addFlash($type, $message);
            return $this->redirectToRoute('cart');
        }

    }
}
