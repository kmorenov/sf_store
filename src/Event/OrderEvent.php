<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class OrderEvent extends Event
{
    private $order;

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     * @return OrderEvent
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

}