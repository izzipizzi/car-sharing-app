<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="orders", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $client_id;

    /**
     * @ORM\OneToOne(targetEntity=Cars::class, inversedBy="orders", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $car_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\OneToOne(targetEntity=Tariff::class, inversedBy="orders", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tariff_id;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientId(): ?User
    {
        return $this->client_id;
    }

    public function setClientId(User $client_id): self
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function getCarId(): ?Cars
    {
        return $this->car_id;
    }

    public function setCarId(Cars $car_id): self
    {
        $this->car_id = $car_id;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->dateFrom;
    }

    public function setDateFrom(\DateTimeInterface $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

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

    public function getTariffId(): ?Tariff
    {
        return $this->tariff_id;
    }

    public function setTariffId(Tariff $tariff_id): self
    {
        $this->tariff_id = $tariff_id;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }
}
