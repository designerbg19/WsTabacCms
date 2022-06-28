<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TlpStokeCourantRepository")
 */
class TlpStokeCourant
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
    private $quantiter;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RapportTlp", mappedBy="stockeCourant")
     */
    private $rapportTlps;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Produit", inversedBy="tlpStokeCourants")
     */
    private $produit;


    public function __construct()
    {
        $this->produit = new ArrayCollection();
        $this->rapportTlps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiter(): ?int
    {
        return $this->quantiter;
    }

    public function setQuantiter(int $quantiter): self
    {
        $this->quantiter = $quantiter;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produit->contains($produit)) {
            $this->produit->removeElement($produit);
        }

        return $this;
    }

    /**
     * @return Collection|RapportTlp[]
     */
    public function getRapportTlps(): Collection
    {
        return $this->rapportTlps;
    }

    public function addRapportTlp(RapportTlp $rapportTlp): self
    {
        if (!$this->rapportTlps->contains($rapportTlp)) {
            $this->rapportTlps[] = $rapportTlp;
            $rapportTlp->addStockeCourant($this);
        }

        return $this;
    }

    public function removeRapportTlp(RapportTlp $rapportTlp): self
    {
        if ($this->rapportTlps->contains($rapportTlp)) {
            $this->rapportTlps->removeElement($rapportTlp);
            $rapportTlp->removeStockeCourant($this);
        }

        return $this;
    }


}
