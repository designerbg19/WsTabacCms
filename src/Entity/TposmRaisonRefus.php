<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TposmRaisonRefusRepository")
 */
class TposmRaisonRefus
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
    private $raison;


    public function __construct()
    {
        $this->rapportTposms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaison(): ?string
    {
        return $this->raison;
    }

    public function setRaison(string $raison): self
    {
        $this->raison = $raison;

        return $this;
    }

    /**
     * @return Collection|RapportTposm[]
     */
    public function getRapportTposms(): Collection
    {
        return $this->rapportTposms;
    }

    public function addRapportTposm(RapportTposm $rapportTposm): self
    {
        if (!$this->rapportTposms->contains($rapportTposm)) {
            $this->rapportTposms[] = $rapportTposm;
            $rapportTposm->setInstalationRaison($this);
        }

        return $this;
    }

    public function removeRapportTposm(RapportTposm $rapportTposm): self
    {
        if ($this->rapportTposms->contains($rapportTposm)) {
            $this->rapportTposms->removeElement($rapportTposm);
            // set the owning side to null (unless already changed)
            if ($rapportTposm->getInstalationRaison() === $this) {
                $rapportTposm->setInstalationRaison(null);
            }
        }

        return $this;
    }
}
