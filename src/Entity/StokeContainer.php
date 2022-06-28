<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StokeContainerRepository")
 */
class StokeContainer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stoke", mappedBy="stokeContainer")
     */
    private $stoke;

    public function __construct()
    {
        $this->stoke = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Stoke[]
     */
    public function getStoke(): Collection
    {
        return $this->stoke;
    }

    public function addStoke(Stoke $stoke): self
    {
        if (!$this->stoke->contains($stoke)) {
            $this->stoke[] = $stoke;
            $stoke->setStokeContainer($this);
        }

        return $this;
    }

    public function removeStoke(Stoke $stoke): self
    {
        if ($this->stoke->contains($stoke)) {
            $this->stoke->removeElement($stoke);
            // set the owning side to null (unless already changed)
            if ($stoke->getStokeContainer() === $this) {
                $stoke->setStokeContainer(null);
            }
        }

        return $this;
    }
}
