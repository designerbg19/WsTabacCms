<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarcConcurentRepository")
 */
class MarcConcurent
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
    private $isConcurent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;


    public function __construct()
    {
        $this->tposm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsConcurent(): ?bool
    {
        return $this->isConcurent;
    }

    public function setIsConcurent(bool $isConcurent): self
    {
        $this->isConcurent = $isConcurent;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTypeDeCompagne(): ?MarkTypeDeCompagne
    {
        return $this->TypeDeCompagne;
    }

    public function setTypeDeCompagne(?MarkTypeDeCompagne $TypeDeCompagne): self
    {
        $this->TypeDeCompagne = $TypeDeCompagne;

        return $this;
    }

    /**
     * @return Collection|PdvTPOSM[]
     */
    public function getTposm(): Collection
    {
        return $this->tposm;
    }

    public function addTposm(PdvTPOSM $tposm): self
    {
        if (!$this->tposm->contains($tposm)) {
            $this->tposm[] = $tposm;
        }

        return $this;
    }

    public function removeTposm(PdvTPOSM $tposm): self
    {
        if ($this->tposm->contains($tposm)) {
            $this->tposm->removeElement($tposm);
        }

        return $this;
    }

    public function getEquipment(): ?MarkNouvelEquipement
    {
        return $this->equipment;
    }

    public function setEquipment(?MarkNouvelEquipement $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * @return Collection|RapportMarketing[]
     */
    public function getRapportMarketings(): Collection
    {
        return $this->rapportMarketings;
    }

    public function addRapportMarketing(RapportMarketing $rapportMarketing): self
    {
        if (!$this->rapportMarketings->contains($rapportMarketing)) {
            $this->rapportMarketings[] = $rapportMarketing;
            $rapportMarketing->addConcurrent($this);
        }

        return $this;
    }

    public function removeRapportMarketing(RapportMarketing $rapportMarketing): self
    {
        if ($this->rapportMarketings->contains($rapportMarketing)) {
            $this->rapportMarketings->removeElement($rapportMarketing);
            $rapportMarketing->removeConcurrent($this);
        }

        return $this;
    }
}
