<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PresenceShopJtiRepository")
 */
class PresenceShopJti
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPresent;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantiter;

    /**
     * @return mixed
     */
    public function getQuantiter()
    {
        return $this->quantiter;
    }

    /**
     * @param mixed $quantiter
     */
    public function setQuantiter($quantiter): void
    {
        $this->quantiter = $quantiter;
    }

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PdvShop", inversedBy="presenceShopJtis")
     */
    private $pdvshop;


    public function __construct()
    {
        $this->pdvshop = new ArrayCollection();
        $this->presenceShopJti = new ArrayCollection();
        $this->rapportPPOSMs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsPresent(): ?bool
    {
        return $this->isPresent;
    }

    public function setIsPresent(?bool $isPresent): self
    {
        $this->isPresent = $isPresent;

        return $this;
    }

    /**
     * @return Collection|PdvShop[]
     */
    public function getPdvshop(): Collection
    {
        return $this->pdvshop;
    }

    public function addPdvshop(PdvShop $pdvshop): self
    {
        if (!$this->pdvshop->contains($pdvshop)) {
            $this->pdvshop[] = $pdvshop;
        }

        return $this;
    }

    public function removePdvshop(PdvShop $pdvshop): self
    {
        if ($this->pdvshop->contains($pdvshop)) {
            $this->pdvshop->removeElement($pdvshop);
        }

        return $this;
    }

    /**
     * @return Collection|RapportPPOSM[]
     */
    public function getRapportPPOSMs(): Collection
    {
        return $this->rapportPPOSMs;
    }

    public function addRapportPPOSM(RapportPPOSM $rapportPPOSM): self
    {
        if (!$this->rapportPPOSMs->contains($rapportPPOSM)) {
            $this->rapportPPOSMs[] = $rapportPPOSM;
            $rapportPPOSM->addPresenceShopJti($this);
        }

        return $this;
    }

    public function removeRapportPPOSM(RapportPPOSM $rapportPPOSM): self
    {
        if ($this->rapportPPOSMs->contains($rapportPPOSM)) {
            $this->rapportPPOSMs->removeElement($rapportPPOSM);
            $rapportPPOSM->removePresenceShopJti($this);
        }

        return $this;
    }

}
