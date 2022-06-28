<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlvTemporaireRepository")
 */
class PlvTemporaire
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
    private $isTemporaire;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TypePlv", inversedBy="plvTemporaires")
     */
    private $typePlv;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuantiterTypePlv", inversedBy="plvTemporaires")
     */
    private $quantiterTypePlv;





    public function __construct()
    {
        $this->typePlv = new ArrayCollection();
        $this->rapportPPOSMs = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsTemporaire(): ?bool
    {
        return $this->isTemporaire;
    }

    public function setIsTemporaire(?bool $isTemporaire): self
    {
        $this->isTemporaire = $isTemporaire;

        return $this;
    }

    /**
     * @return Collection|TypePlv[]
     */
    public function getTypePlv(): Collection
    {
        return $this->typePlv;
    }

    public function addTypePlv(TypePlv $typePlv): self
    {
        if (!$this->typePlv->contains($typePlv)) {
            $this->typePlv[] = $typePlv;
        }

        return $this;
    }

    public function removeTypePlv(TypePlv $typePlv): self
    {
        if ($this->typePlv->contains($typePlv)) {
            $this->typePlv->removeElement($typePlv);
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
            $rapportPPOSM->addPlvTemporaire($this);
        }

        return $this;
    }

    public function removeRapportPPOSM(RapportPPOSM $rapportPPOSM): self
    {
        if ($this->rapportPPOSMs->contains($rapportPPOSM)) {
            $this->rapportPPOSMs->removeElement($rapportPPOSM);
            $rapportPPOSM->removePlvTemporaire($this);
        }

        return $this;
    }

    public function getQuantiterTypePlv(): ?QuantiterTypePlv
    {
        return $this->quantiterTypePlv;
    }

    public function setQuantiterTypePlv(?QuantiterTypePlv $quantiterTypePlv): self
    {
        $this->quantiterTypePlv = $quantiterTypePlv;

        return $this;
    }






}
