<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RaisonPresontoireRepository")
 */
class RaisonPresontoire
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
    private $raison;

    public function __construct()
    {
        $this->presencePresentoireJtis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaison(): ?string
    {
        return $this->raison;
    }

    public function setRaison(?string $raison): self
    {
        $this->raison = $raison;

        return $this;
    }

    /**
     * @return Collection|PresencePresentoireJti[]
     */
    public function getPresencePresentoireJtis(): Collection
    {
        return $this->presencePresentoireJtis;
    }

    public function addPresencePresentoireJti(PresencePresentoireJti $presencePresentoireJti): self
    {
        if (!$this->presencePresentoireJtis->contains($presencePresentoireJti)) {
            $this->presencePresentoireJtis[] = $presencePresentoireJti;
            $presencePresentoireJti->addRaison($this);
        }

        return $this;
    }

    public function removePresencePresentoireJti(PresencePresentoireJti $presencePresentoireJti): self
    {
        if ($this->presencePresentoireJtis->contains($presencePresentoireJti)) {
            $this->presencePresentoireJtis->removeElement($presencePresentoireJti);
            $presencePresentoireJti->removeRaison($this);
        }

        return $this;
    }
}
