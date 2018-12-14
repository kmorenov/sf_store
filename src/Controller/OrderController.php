<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Event\OrderEvent;
use App\Service\CartManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Tests\Controller;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderController extends AbstractController
{
    private $formFactory;
    private $entityManager;
    private $cartManager;
//    private $session;

    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        CartManager $cartManager
//        SessionInterface $session
    )
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->cartManager = $cartManager;
//        $this->session = $session;
    }

    /**
     * @Route("/order", name="order")
     */
    public function index(Request $request, EventDispatcherInterface $dispatcher)
    {
        $order = new Orders();
        $orderForm = $this->formFactory->create(OrderType::class, $order);
        $orderForm->handleRequest($request);

        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $order = $orderForm->getData();

            if ($order instanceof Orders) {
                $this->entityManager->persist($order);
                $this->entityManager->flush();
                $this->cartManager->emptyCart();

                $orderEvent = new OrderEvent();
                $orderEvent->setOrder($order);

                $dispatcher->dispatch('order.persist', $orderEvent);

                $type = 'success';
                $message = 'Your order has been submitted.';
            }
            else {
                $type = 'error';
                $message = 'Your order could NOT be submitted.';
            }

            $this->addFlash($type, $message);
            return $this->redirectToRoute('cart');
        }

    }
}
