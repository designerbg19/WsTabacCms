<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypePlvRepository")
 */
class TypePlv
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
    private $type;





    public function __construct()
    {
        $this->plvTemporaires = new ArrayCollection();
    }

       public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getQuantiterTypePlv(): ?QuantiterTypePlv
    {
        return $this->quantiterTypePlv;
    }

    public function setQuantiterTypePlv(?QuantiterTypePlv $quantiterTypePlv): self
    {
        $this->quantiterTypePlv = $quantiterTypePlv;

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
            $plvTemporaire->addTypePlv($this);
        }

        return $this;
    }

    public function removePlvTemporaire(PlvTemporaire $plvTemporaire): self
    {
        if ($this->plvTemporaires->contains($plvTemporaire)) {
            $this->plvTemporaires->removeElement($plvTemporaire);
            $plvTemporaire->removeTypePlv($this);
        }

        return $this;
    }


   }
