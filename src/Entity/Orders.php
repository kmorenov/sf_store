<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Null_;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $lastName;

//    /**
//     * @ORM\Column(type="integer")
//     */
//    private $price;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;


    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderPosition", mappedBy="orders")
     */
    private $orderPosition;


    public function __construct()
    {
        $this->orderPosition = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->id ? (string)$this->id : 'New';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist()
     */

    public function setCreatedAt(): self //\DateTimeInterface $createdAt)
    {
        $this->createdAt = new \DateTime();  //$createdAt;

        return $this;
    }

    /**
     * @return Collection|OrderPosition[]
     */
    public function getOrderPosition(): Collection
    {
        return $this->orderPosition;
    }

    public function addOrderPosition(OrderPosition $orderPosition): self
    {
        if (!$this->orderPosition->contains($orderPosition)) {
            $this->orderPosition[] = $orderPosition;
            $orderPosition->setOrders($this);
        }

        return $this;
    }

    public function removeOrderPosition(OrderPosition $orderPosition): self
    {
        if ($this->orderPosition->contains($orderPosition)) {
            $this->orderPosition->removeElement($orderPosition);
            // set the owning side to null (unless already changed)
            if ($orderPosition->getOrders() === $this) {
                $orderPosition->setOrders(null);
            }
        }

        return $this;
    }
}
