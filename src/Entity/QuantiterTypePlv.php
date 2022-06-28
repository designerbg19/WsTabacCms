<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuantiterTypePlvRepository")
 */
class QuantiterTypePlv
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantiter;



    public function __construct()
    {
        $this->typePlv = new ArrayCollection();
        $this->plvTemporaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiter(): ?int
    {
        return $this->quantiter;
    }

    public function setQuantiter(?int $quantiter): self
    {
        $this->quantiter = $quantiter;

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
            $typePlv->setQuantiterTypePlv($this);
        }

        return $this;
    }

    public function removeTypePlv(TypePlv $typePlv): self
    {
        if ($this->typePlv->contains($typePlv)) {
            $this->typePlv->removeElement($typePlv);
            // set the owning side to null (unless already changed)
            if ($typePlv->getQuantiterTypePlv() === $this) {
                $typePlv->setQuantiterTypePlv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PlvTemporaire[]
     */
    public function getPlvTemporaires(): Collection
    {
        return $this->plvTemporaires;
    }

    public function addPlvTemporaire(PlvTemporaire $plvTemporaire): self
    {
        if (!$this->plvTemporaires->contains($plvTemporaire)) {
            $this->plvTemporaires[] = $plvTemporaire;
            $plvTemporaire->setQuantiterTypePlv($this);
        }

        return $this;
    }

    public function removePlvTemporaire(PlvTemporaire $plvTemporaire): self
    {
        if ($this->plvTemporaires->contains($plvTemporaire)) {
            $this->plvTemporaires->removeElement($plvTemporaire);
            // set the owning side to null (unless already changed)
            if ($plvTemporaire->getQuantiterTypePlv() === $this) {
                $plvTemporaire->setQuantiterTypePlv(null);
            }
        }

        return $this;
    }
}
