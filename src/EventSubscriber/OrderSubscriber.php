<?php

namespace App\EventSubscriber;

use App\Event\OrderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class OrderSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'order.persist' => array(
                array('onOrder', 10),
            ),
            'order.persist2' => array(
                array('onOrder', 10),
            ),
        );
    }

    public function onOrder(OrderEvent $orderEvent)
    {
        dump('OrderSubscriber');
    }
}