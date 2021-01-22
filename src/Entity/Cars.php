<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CarsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CarsRepository::class)
 * @ApiResource(
 *  collectionOperations={"get"={"normalization_context"={"groups"="cars:list"}}},
 *  itemOperations={"get"={"normalization_context"={"groups"="cars:item"}}},
 *  order={"status"="DESC", "name"="ASC"},
 *  paginationEnabled=false
 *)
 *
 */
class Cars
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({
     * "cars:list", "cars:item"
     * })
     */

    private
        $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({
     * "cars:list", "cars:item"
     * })
     */
    private
        $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cars:list", "cars:item"})
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cars:list", "cars:item"})
     */
    private $color;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"cars:list", "cars:item"})
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cars:list", "cars:item"})
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cars:list", "cars:item"})
     */
    private $status;
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cars:list", "cars:item"})
     */
    private $location;

    /**
     * @ORM\ManyToOne  (targetEntity= CarTypes::class)
     * @Groups({"cars:list", "cars:item"})
     */
    private $type_id;

    /**
     * @ORM\Column(type="date", nullable=true, options={"default" : "2021-01-07"})
     * @Groups({"cars:list", "cars:item"})
     */
    private $dateTo;
    /**
     * @ORM\Column(type="time",nullable=true, options={"default" : "17:16:18"})
     * @Groups({"cars:list", "cars:item"})
     */
    private $time_to;
    /**
     * @ORM\OneToMany (targetEntity=Orders::class, mappedBy="car_id", cascade={"persist", "remove"})
     */
    private $orders;

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

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(Orders $orders): self
    {
        $this->orders = $orders;

        // set the owning side of the relation if necessary
        if ($orders->getCarId() !== $this) {
            $orders->setCarId($this);
        }

        return $this;
    }


    public function getType(): ?CarTypes
    {
        return $this->type_id;
    }


    public function setType(CarTypes $type_id): self
    {
        $this->type_id = $type_id;

        return $this;
    }

    public function getDateTo(): ?\DateTimeInterface
    {
        return $this->dateTo;
    }

    public function setDateTo(\DateTimeInterface $dateTo): self
    {
        $this->dateTo = $dateTo;

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

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): self
    {
        $this->location = $location;
        return $this;
    }
}
