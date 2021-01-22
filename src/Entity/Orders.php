<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 * @ApiResource(
 *  collectionOperations={"get"={"normalization_context"={"groups"="orders:list"}}},
 *  itemOperations={"get"={"normalization_context"={"groups"="orders:item"}}},
 *  order={"price"="DESC"},
 *  paginationEnabled=false
 *)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({
     * "orders:list", "orders:item"
     * })
     */
    private $id;

    /**
     * @ORM\ManyToOne (targetEntity=User::class, inversedBy="orders", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({
     * "orders:list", "orders:item"
     * })
     */
    private $client_id;

    /**
     *
     * @ORM\ManyToOne  (targetEntity=Cars::class, inversedBy="orders", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({
     * "orders:list", "orders:item"
     * })
     */
    private $car_id;

    /**
     *
     * @ORM\ManyToOne  (targetEntity=Tariff::class,cascade={"persist", "remove"})
     * @Groups({
     * "orders:list", "orders:item"
     * })
     */
    private $tariff_id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     * "orders:list", "orders:item"
     * })
     */
    private $location;

    /**
     * @ORM\Column(type="date")
     * @Groups({
     * "orders:list", "orders:item"
     * })
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="integer")
     * @Groups({
     * "orders:list", "orders:item"
     * })
     */
    private $price;


    /**
     * @ORM\Column(type="time")
     * @Groups({
     * "orders:list", "orders:item"
     * })
     */
    private $time_from;
    /**
     * @ORM\Column(type="time")
     * @Groups({
     * "orders:list", "orders:item"
     * })
     */
    private $time_to;

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

    public function getTariffId(): ?Tariff
    {
        return $this->tariff_id;
    }

    public function setTariffId(Tariff $tariff_id): self
    {
        $this->tariff_id = $tariff_id;

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


    public function getTimeFrom(): ?\DateTimeInterface
    {
        return $this->time_from;
    }

    public function setTimeFrom(\DateTimeInterface $time_from): self
    {
        $this->time_from = $time_from;

        return $this;
    }

    public function getTimeTo(): ?\DateTimeInterface
    {
        return $this->time_to;
    }

    public function setTimeTo(\DateTimeInterface $time_to): self
    {
        $this->time_to = $time_to;

        return $this;
    }
}
