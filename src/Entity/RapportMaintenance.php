<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RapportMaintenanceRepository")
 */
class RapportMaintenance
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
    private $isMaintenance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $explication;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RapportMaintListMa", inversedBy="rapportMaintenances")
     */
    private $diffinitionMa;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RapportGlobal", inversedBy="rapportMaintenance")
     */
    private $rapportGlobal;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commentaire", inversedBy="rapportMaintenances")
     */
    private $commentMain;

    public function __construct()
    {
        $this->diffinitionMa = new ArrayCollection();
        $this->commentMain = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsMaintenance(): ?bool
    {
        return $this->isMaintenance;
    }

    public function setIsMaintenance(bool $isMaintenance): self
    {
        $this->isMaintenance = $isMaintenance;

        return $this;
    }

    public function getExplication(): ?string
    {
        return $this->explication;
    }

    public function setExplication(string $explication): self
    {
        $this->explication = $explication;

        return $this;
    }

    /**
     * @return Collection|RapportMaintListMa[]
     */
    public function getDiffinitionMa(): Collection
    {
        return $this->diffinitionMa;
    }

    public function addDiffinitionMa(RapportMaintListMa $diffinitionMa): self
    {
        if (!$this->diffinitionMa->contains($diffinitionMa)) {
            $this->diffinitionMa[] = $diffinitionMa;
        }

        return $this;
    }

    public function removeDiffinitionMa(RapportMaintListMa $diffinitionMa): self
    {
        if ($this->diffinitionMa->contains($diffinitionMa)) {
            $this->diffinitionMa->removeElement($diffinitionMa);
        }

        return $this;
    }

    public function getRapportGlobal(): ?RapportGlobal
    {
        return $this->rapportGlobal;
    }

    public function setRapportGlobal(?RapportGlobal $rapportGlobal): self
    {
        $this->rapportGlobal = $rapportGlobal;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentMain(): Collection
    {
        return $this->commentMain;
    }

    public function addCommentMain(Commentaire $commentMain): self
    {
        if (!$this->commentMain->contains($commentMain)) {
            $this->commentMain[] = $commentMain;
        }

        return $this;
    }

    public function removeCommentMain(Commentaire $commentMain): self
    {
        if ($this->commentMain->contains($commentMain)) {
            $this->commentMain->removeElement($commentMain);
        }

        return $this;
    }
}
