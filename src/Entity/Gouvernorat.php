<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GouvernoratRepository")
 */
class Gouvernorat
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
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone", inversedBy="gouvernorat")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Deligation", mappedBy="gouvernorat")
     */
    private $deligation;

    public function __construct()
    {
        $this->deligation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return Collection|Deligation[]
     */
    public function getDeligation(): Collection
    {
        return $this->deligation;
    }

    public function addDeligation(Deligation $deligation): self
    {
        if (!$this->deligation->contains($deligation)) {
            $this->deligation[] = $deligation;
            $deligation->setGouvernorat($this);
        }

        return $this;
    }

    public function removeDeligation(Deligation $deligation): self
    {
        if ($this->deligation->contains($deligation)) {
            $this->deligation->removeElement($deligation);
            // set the owning side to null (unless already changed)
            if ($deligation->getGouvernorat() === $this) {
                $deligation->setGouvernorat(null);
            }
        }

        return $this;
    }
}
