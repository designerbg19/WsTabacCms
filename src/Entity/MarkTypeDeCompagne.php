<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarkTypeDeCompagneRepository")
 */
class MarkTypeDeCompagne
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;


    public function __construct()
    {
        $this->rapportMarketings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $rapportMarketing->setTypeDeCompagnie($this);
        }

        return $this;
    }

    public function removeRapportMarketing(RapportMarketing $rapportMarketing): self
    {
        if ($this->rapportMarketings->contains($rapportMarketing)) {
            $this->rapportMarketings->removeElement($rapportMarketing);
            // set the owning side to null (unless already changed)
            if ($rapportMarketing->getTypeDeCompagnie() === $this) {
                $rapportMarketing->setTypeDeCompagnie(null);
            }
        }

        return $this;
    }
}
