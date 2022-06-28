<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NbrEnfantRepository")
 */
class NbrEnfant
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
    private $nbrEnfant;


    public function __construct()
    {
        $this->infoClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrEnfant(): ?string
    {
        return $this->nbrEnfant;
    }

    public function setNbrEnfant(string $nbrEnfant): self
    {
        $this->nbrEnfant = $nbrEnfant;

        return $this;
    }

    /**
     * @return Collection|InfoClient[]
     */
    public function getInfoClients(): Collection
    {
        return $this->infoClients;
    }

    public function addInfoClient(InfoClient $infoClient): self
    {
        if (!$this->infoClients->contains($infoClient)) {
            $this->infoClients[] = $infoClient;
            $infoClient->setNbrEnfant($this);
        }

        return $this;
    }

    public function removeInfoClient(InfoClient $infoClient): self
    {
        if ($this->infoClients->contains($infoClient)) {
            $this->infoClients->removeElement($infoClient);
            // set the owning side to null (unless already changed)
            if ($infoClient->getNbrEnfant() === $this) {
                $infoClient->setNbrEnfant(null);
            }
        }

        return $this;
    }
}
