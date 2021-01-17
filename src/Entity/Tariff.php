<?php

namespace App\Entity;

use App\Repository\TariffRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TariffRepository::class)
 */
class Tariff
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;



//    /**
//     * @ORM\OneToMany (targetEntity=Orders::class, mappedBy="tariff_id", cascade={"persist", "remove"})
//     */
//
//    private $orders;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

//    public function getOrders(): ?Orders
//    {
//        return $this->orders;
//    }
//
//    public function setOrders(Orders $orders): self
//    {
//        $this->orders = $orders;
//
//        // set the owning side of the relation if necessary
//        if ($orders->getCarId() !== $this) {
//            $orders->setCarId($this);
//        }
//
//        return $this;
//    }

}
