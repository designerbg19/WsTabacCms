<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PresencePresentoireNotJtiRepository")
 */
class PresencePresentoireNotJti
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
     * @ORM\ManyToMany(targetEntity="App\Entity\PdvPresentoire", inversedBy="presencePresentoireNotJtis")
     */
    private $pdvPresentoire;



    public function __construct()
    {
        $this->pdvPresentoire = new ArrayCollection();
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

    public function getQuantiter(): ?int
    {
        return $this->quantiter;
    }

    public function setQuantiter(?int $quantiter): self
    {
        $this->quantiter = $quantiter;

        return $this;
    }

    /**
     * @return Collection|PdvPresentoire[]
     */
    public function getPdvPresentoire(): Collection
    {
        return $this->pdvPresentoire;
    }

    public function addPdvPresentoire(PdvPresentoire $pdvPresentoire): self
    {
        if (!$this->pdvPresentoire->contains($pdvPresentoire)) {
            $this->pdvPresentoire[] = $pdvPresentoire;
        }

        return $this;
    }

    public function removePdvPresentoire(PdvPresentoire $pdvPresentoire): self
    {
        if ($this->pdvPresentoire->contains($pdvPresentoire)) {
            $this->pdvPresentoire->removeElement($pdvPresentoire);
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
            $rapportPPOSM->addPresencePresentoireNotJti($this);
        }

        return $this;
    }

    public function removeRapportPPOSM(RapportPPOSM $rapportPPOSM): self
    {
        if ($this->rapportPPOSMs->contains($rapportPPOSM)) {
            $this->rapportPPOSMs->removeElement($rapportPPOSM);
            $rapportPPOSM->removePresencePresentoireNotJti($this);
        }

        return $this;
    }

}
