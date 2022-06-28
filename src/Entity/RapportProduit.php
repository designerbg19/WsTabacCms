<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RapportProduitRepository")
 */
class RapportProduit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDispo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isVeder;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Produit", inversedBy="rapportProduits")
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RapportGlobal", inversedBy="RapportProduit")
     */
    private $rapportGlobal;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commentaire", inversedBy="rapportProduits")
     */
    private $commentProduit;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
        $this->commentProduit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsDispo(): ?bool
    {
        return $this->isDispo;
    }

    public function setIsDispo(bool $isDispo): self
    {
        $this->isDispo = $isDispo;

        return $this;
    }

    public function getIsVeder(): ?bool
    {
        return $this->isVeder;
    }

    public function setIsVeder(?bool $isVeder): self
    {
        $this->isVeder = $isVeder;

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

    public function getRapportGlobal(): ?RapportGlobal
    {
        return $this->rapportGlobal;
    }

    public function setRapportGlobal(?RapportGlobal $rapportGlobal): self
    {
        $this->rapportGlobal = $rapportGlobal;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentProduit(): Collection
    {
        return $this->commentProduit;
    }

    public function addCommentProduit(Commentaire $commentProduit): self
    {
        if (!$this->commentProduit->contains($commentProduit)) {
            $this->commentProduit[] = $commentProduit;
        }

        return $this;
    }

    public function removeCommentProduit(Commentaire $commentProduit): self
    {
        if ($this->commentProduit->contains($commentProduit)) {
            $this->commentProduit->removeElement($commentProduit);
        }

        return $this;
    }
}
