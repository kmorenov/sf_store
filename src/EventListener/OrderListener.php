<?php

namespace App\EventListener;

use App\Event\OrderEvent;

class OrderListener
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onOrderPersist(OrderEvent $orderEvent)
    {
        dump($orderEvent);
    }

    private function sendEmailToAdmin()
    {

    }

    private function sendEmailToCustomer()
    {

    }

    private function sendEmail()
    {

    }
}