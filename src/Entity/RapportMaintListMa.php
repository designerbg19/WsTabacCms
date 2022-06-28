<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RapportMaintListMaRepository")
 */
class RapportMaintListMa
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
    private $diffintion;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RapportMaintenance", mappedBy="diffinitionMa")
     */
    private $rapportMaintenances;

    public function __construct()
    {
        $this->rapportMaintenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiffintion(): ?string
    {
        return $this->diffintion;
    }

    public function setDiffintion(string $diffintion): self
    {
        $this->diffintion = $diffintion;

        return $this;
    }

    /**
     * @return Collection|RapportMaintenance[]
     */
    public function getRapportMaintenances(): Collection
    {
        return $this->rapportMaintenances;
    }

    public function addRapportMaintenance(RapportMaintenance $rapportMaintenance): self
    {
        if (!$this->rapportMaintenances->contains($rapportMaintenance)) {
            $this->rapportMaintenances[] = $rapportMaintenance;
            $rapportMaintenance->addDiffinitionMa($this);
        }

        return $this;
    }

    public function removeRapportMaintenance(RapportMaintenance $rapportMaintenance): self
    {
        if ($this->rapportMaintenances->contains($rapportMaintenance)) {
            $this->rapportMaintenances->removeElement($rapportMaintenance);
            $rapportMaintenance->removeDiffinitionMa($this);
        }

        return $this;
    }
}
