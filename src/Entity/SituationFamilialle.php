<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SituationFamilialleRepository")
 */
class SituationFamilialle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sitation;



    public function __construct()
    {
        $this->infoClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSitation(): ?string
    {
        return $this->sitation;
    }

    public function setSitation(?string $sitation): self
    {
        $this->sitation = $sitation;

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
            $infoClient->setSituationFamil($this);
        }

        return $this;
    }

    public function removeInfoClient(InfoClient $infoClient): self
    {
        if ($this->infoClients->contains($infoClient)) {
            $this->infoClients->removeElement($infoClient);
            // set the owning side to null (unless already changed)
            if ($infoClient->getSituationFamil() === $this) {
                $infoClient->setSituationFamil(null);
            }
        }

        return $this;
    }
}
