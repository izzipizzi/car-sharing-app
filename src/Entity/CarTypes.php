<?php

namespace App\Entity;

use App\Repository\CarTypesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarTypesRepository::class)
 */
class CarTypes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_desc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeName(): ?string
    {
        return $this->type_name;
    }

    public function setTypeName(string $type_name): self
    {
        $this->type_name = $type_name;

        return $this;
    }

    public function getTypeDesc(): ?string
    {
        return $this->type_desc;
    }

    public function setTypeDesc(string $type_desc): self
    {
        $this->type_desc = $type_desc;

        return $this;
    }
}
