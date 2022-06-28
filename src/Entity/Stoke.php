<?php

namespace App\Entity;

use app\Entity\StokeContainer;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StokeRepository")
 */
class Stoke
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true )
     */
    private $quantiter ;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StokeContainer", inversedBy="stoke")
     */
    private $stokeContainer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produit", cascade={"persist", "remove"})
     */
    private $produit;

    /**
     * Stoke constructor.
     * @param $quantiter
     * @param $stokeContainer
     * @param $produit
     */



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiter(): ?int
    {
        return $this->quantiter;
    }

    public function setQuantiter(?int $quantiter): self
    {
        $this->quantiter = $quantiter;

        return $this;
    }

    public function getStokeContainer(): ?StokeContainer
    {
        return $this->stokeContainer;
    }

    public function setStokeContainer(?StokeContainer $stokeContainer): self
    {
        $this->stokeContainer = $stokeContainer;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
