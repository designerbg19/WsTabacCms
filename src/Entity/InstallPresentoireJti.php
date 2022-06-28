<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstallPresentoireJtiRepository")
 */
class InstallPresentoireJti
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
    private $isInstallation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantiter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PdvPresentoire", inversedBy="installPresentoireJtis")
     */
    private $presentoire;


    public function __construct()
    {
        $this->rapportPPOSMs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsInstallation(): ?bool
    {
        return $this->isInstallation;
    }

    public function setIsInstallation(?bool $isInstallation): self
    {
        $this->isInstallation = $isInstallation;

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

    public function getPresentoire(): ?PdvPresentoire
    {
        return $this->presentoire;
    }

    public function setPresentoire(?PdvPresentoire $presentoire): ?self
    {
        $this->presentoire = $presentoire;

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
            $rapportPPOSM->setInstallPresentoireJti($this);
        }

        return $this;
    }

    public function removeRapportPPOSM(RapportPPOSM $rapportPPOSM): self
    {
        if ($this->rapportPPOSMs->contains($rapportPPOSM)) {
            $this->rapportPPOSMs->removeElement($rapportPPOSM);
            // set the owning side to null (unless already changed)
            if ($rapportPPOSM->getInstallPresentoireJti() === $this) {
                $rapportPPOSM->setInstallPresentoireJti(null);
            }
        }

        return $this;
    }
}
