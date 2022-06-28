<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarkNouvelEquipementRepository")
 */
class MarkNouvelEquipement
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MarcConcurent", mappedBy="equipment")
     */
    private $marcConcurents;



    public function __construct()
    {
        $this->marcConcurents = new ArrayCollection();
        $this->rapportMarketing = new ArrayCollection();
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
     * @return Collection|MarcConcurent[]
     */
    public function getMarcConcurents(): Collection
    {
        return $this->marcConcurents;
    }

    public function addMarcConcurent(MarcConcurent $marcConcurent): self
    {
        if (!$this->marcConcurents->contains($marcConcurent)) {
            $this->marcConcurents[] = $marcConcurent;
            $marcConcurent->setEquipment($this);
        }

        return $this;
    }

    public function removeMarcConcurent(MarcConcurent $marcConcurent): self
    {
        if ($this->marcConcurents->contains($marcConcurent)) {
            $this->marcConcurents->removeElement($marcConcurent);
            // set the owning side to null (unless already changed)
            if ($marcConcurent->getEquipment() === $this) {
                $marcConcurent->setEquipment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RapportMarketing[]
     */
    public function getRapportMarketing(): Collection
    {
        return $this->rapportMarketing;
    }

    public function addRapportMarketing(RapportMarketing $rapportMarketing): self
    {
        if (!$this->rapportMarketing->contains($rapportMarketing)) {
            $this->rapportMarketing[] = $rapportMarketing;
            $rapportMarketing->setNouvelEquipment($this);
        }

        return $this;
    }

    public function removeRapportMarketing(RapportMarketing $rapportMarketing): self
    {
        if ($this->rapportMarketing->contains($rapportMarketing)) {
            $this->rapportMarketing->removeElement($rapportMarketing);
            // set the owning side to null (unless already changed)
            if ($rapportMarketing->getNouvelEquipment() === $this) {
                $rapportMarketing->setNouvelEquipment(null);
            }
        }

        return $this;
    }
}
