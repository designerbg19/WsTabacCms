<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PresencePresentoireJtiRepository")
 */
class PresencePresentoireJti
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
     * @ORM\Column(type="string", length=255)
     */
    private $AutreRaison;

    /**
     * @return mixed
     */
    public function getAutreRaison()
    {
        return $this->AutreRaison;
    }

    /**
     * @param mixed $AutreRaison
     */
    public function setAutreRaison($AutreRaison): void
    {
        $this->AutreRaison = $AutreRaison;
    }

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
     * @ORM\ManyToMany(targetEntity="App\Entity\RaisonPresontoire", inversedBy="presencePresentoireJtis")
     */
    private $raison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PdvPresentoire", inversedBy="presence")
     */
    private $pdvPresentoire;

    public function __construct()
    {
        $this->presentoire = new ArrayCollection();
        $this->raison = new ArrayCollection();
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
     * @return Collection|RaisonPresontoire[]
     */
    public function getRaison(): Collection
    {
        return $this->raison;
    }

    public function addRaison(RaisonPresontoire $raison): self
    {
        if (!$this->raison->contains($raison)) {
            $this->raison[] = $raison;
        }

        return $this;
    }

    public function removeRaison(RaisonPresontoire $raison): self
    {
        if ($this->raison->contains($raison)) {
            $this->raison->removeElement($raison);
        }

        return $this;
    }

    public function getPdvPresentoire(): ?PdvPresentoire
    {
        return $this->pdvPresentoire;
    }

    public function setPdvPresentoire(?PdvPresentoire $pdvPresentoire): self
    {
        $this->pdvPresentoire = $pdvPresentoire;

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
            $rapportPPOSM->setPresencePresentoireJti($this);
        }

        return $this;
    }

    public function removeRapportPPOSM(RapportPPOSM $rapportPPOSM): self
    {
        if ($this->rapportPPOSMs->contains($rapportPPOSM)) {
            $this->rapportPPOSMs->removeElement($rapportPPOSM);
            // set the owning side to null (unless already changed)
            if ($rapportPPOSM->getPresencePresentoireJti() === $this) {
                $rapportPPOSM->setPresencePresentoireJti(null);
            }
        }

        return $this;
    }
}
