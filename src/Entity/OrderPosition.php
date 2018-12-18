<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderPositionRepository")
 */
class OrderPosition
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $productId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Orders", inversedBy="orderPosition")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orders;





    public function __construct($price, $quantity, $productId, $orders)
    {
        $this->orders = new ArrayCollection();

        $this->price = $price;
        $this->quantity = $quantity;
        $this->productId = $productId;
        $this->orders = $orders;

    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getId() ? 'Order Id: ' . $this->getId() : '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): self
    {
        $this->orders = $orders;

        return $this;
    }



}
