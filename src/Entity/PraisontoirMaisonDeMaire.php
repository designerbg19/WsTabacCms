<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PraisontoirMaisonDeMaireRepository")
 */
class PraisontoirMaisonDeMaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $maisonDeMaire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isJti;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PdvPresentoire", mappedBy="maisonMaire")
     */
    private $pdvPresentoires;



    public function __construct()
    {
        $this->presentoire = new ArrayCollection();
        $this->pdvPresentoires = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getIsJti()
    {
        return $this->isJti;
    }

    /**
     * @param mixed $isJti
     */
    public function setIsJti($isJti): void
    {
        $this->isJti = $isJti;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaisonDeMaire(): ?string
    {
        return $this->maisonDeMaire;
    }

    public function setMaisonDeMaire(?string $maisonDeMaire): self
    {
        $this->maisonDeMaire = $maisonDeMaire;

        return $this;
    }

    /**
     * @return Collection|PdvPresentoire[]
     */
    public function getPresentoire(): Collection
    {
        return $this->presentoire;
    }

    public function addPresentoire(PdvPresentoire $presentoire): self
    {
        if (!$this->presentoire->contains($presentoire)) {
            $this->presentoire[] = $presentoire;
            $presentoire->setPraisontoirMaisonDeMaire($this);
        }

        return $this;
    }

    public function removePresentoire(PdvPresentoire $presentoire): self
    {
        if ($this->presentoire->contains($presentoire)) {
            $this->presentoire->removeElement($presentoire);
            // set the owning side to null (unless already changed)
            if ($presentoire->getPraisontoirMaisonDeMaire() === $this) {
                $presentoire->setPraisontoirMaisonDeMaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PdvPresentoire[]
     */
    public function getPdvPresentoires(): Collection
    {
        return $this->pdvPresentoires;
    }

    public function addPdvPresentoire(PdvPresentoire $pdvPresentoire): self
    {
        if (!$this->pdvPresentoires->contains($pdvPresentoire)) {
            $this->pdvPresentoires[] = $pdvPresentoire;
            $pdvPresentoire->setMaisonMaire($this);
        }

        return $this;
    }

    public function removePdvPresentoire(PdvPresentoire $pdvPresentoire): self
    {
        if ($this->pdvPresentoires->contains($pdvPresentoire)) {
            $this->pdvPresentoires->removeElement($pdvPresentoire);
            // set the owning side to null (unless already changed)
            if ($pdvPresentoire->getMaisonMaire() === $this) {
                $pdvPresentoire->setMaisonMaire(null);
            }
        }

        return $this;
    }
}
