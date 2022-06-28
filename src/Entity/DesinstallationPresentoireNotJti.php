<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DesinstallationPresentoireNotJtiRepository")
 */
class DesinstallationPresentoireNotJti
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
    private $isDesinstall;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantiter;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PdvPresentoire", inversedBy="desinstallationPresentoireNotJtis")
     */
    private $PdvPresentoire;

    public function __construct()
    {
        $this->PdvPresentoire = new ArrayCollection();
        $this->rapportPPOSMs = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsDesinstall(): ?bool
    {
        return $this->isDesinstall;
    }

    public function setIsDesinstall(?bool $isDesinstall): self
    {
        $this->isDesinstall = $isDesinstall;

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
        return $this->PdvPresentoire;
    }

    public function addPdvPresentoire(PdvPresentoire $pdvPresentoire): self
    {
        if (!$this->PdvPresentoire->contains($pdvPresentoire)) {
            $this->PdvPresentoire[] = $pdvPresentoire;
        }

        return $this;
    }

    public function removePdvPresentoire(PdvPresentoire $pdvPresentoire): self
    {
        if ($this->PdvPresentoire->contains($pdvPresentoire)) {
            $this->PdvPresentoire->removeElement($pdvPresentoire);
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
            $rapportPPOSM->addDesIntallPresentoireNotJti($this);
        }

        return $this;
    }

    public function removeRapportPPOSM(RapportPPOSM $rapportPPOSM): self
    {
        if ($this->rapportPPOSMs->contains($rapportPPOSM)) {
            $this->rapportPPOSMs->removeElement($rapportPPOSM);
            $rapportPPOSM->removeDesIntallPresentoireNotJti($this);
        }

        return $this;
    }


}
