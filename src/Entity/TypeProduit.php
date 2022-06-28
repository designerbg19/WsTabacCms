<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Produit;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeProduitRepository")
 */
class TypeProduit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isJti;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIsJti(): ?bool
    {
        return $this->isJti;
    }

    public function setIsJti(bool $isJti): self
    {
        $this->isJti = $isJti;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * @param mixed $produits
     */
    public function setProduits($produits): void
    {
        $this->produits = $produits;
    }
}
