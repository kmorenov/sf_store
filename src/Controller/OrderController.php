<?php

namespace App\Controller;

use App\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Tests\Controller;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;

class OrderController extends AbstractController
{
    private $formFactory;
    private $entityManager;

    public function __construct(FormFactoryInterface $formFactory,
    EntityManagerInterface $entityManager)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/order", name="order")
     */
    public function index(Request $request)
    {
        $order = new Orders();
        $orderForm = $this->formFactory->create(OrderType::class, $order);
        $orderForm->handleRequest($request);

        dump($_POST);
        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $order = $orderForm->getData();

            $this->entityManager->persist($order);

            $this->entityManager->flush();

            return $order;
        }

        return 'Something went WRONG';
    }

}
