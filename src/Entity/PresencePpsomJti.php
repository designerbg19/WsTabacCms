<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PresencePpsomJtiRepository")
 */
class PresencePpsomJti
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
     * @ORM\ManyToMany(targetEntity="App\Entity\PdvPPSOM", inversedBy="presencePpsomJtis")
     */
    private $pdvPpsom;




    public function __construct()
    {
        $this->pdvPpsom = new ArrayCollection();
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
     * @return Collection|PdvPPSOM[]
     */
    public function getPdvPpsom(): Collection
    {
        return $this->pdvPpsom;
    }

    public function addPdvPpsom(PdvPPSOM $pdvPpsom): self
    {
        if (!$this->pdvPpsom->contains($pdvPpsom)) {
            $this->pdvPpsom[] = $pdvPpsom;
        }

        return $this;
    }

    public function removePdvPpsom(PdvPPSOM $pdvPpsom): self
    {
        if ($this->pdvPpsom->contains($pdvPpsom)) {
            $this->pdvPpsom->removeElement($pdvPpsom);
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
            $rapportPPOSM->setPresencePpsomJti($this);
        }

        return $this;
    }

    public function removeRapportPPOSM(RapportPPOSM $rapportPPOSM): self
    {
        if ($this->rapportPPOSMs->contains($rapportPPOSM)) {
            $this->rapportPPOSMs->removeElement($rapportPPOSM);
            // set the owning side to null (unless already changed)
            if ($rapportPPOSM->getPresencePpsomJti() === $this) {
                $rapportPPOSM->setPresencePpsomJti(null);
            }
        }

        return $this;
    }
}
