<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeligationRepository")
 */
class Deligation
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Gouvernorat", inversedBy="deligation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gouvernorat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Quartier", mappedBy="deligation")
     */
    private $quartier;

    public function __construct()
    {
        $this->quartier = new ArrayCollection();
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

    public function getGouvernorat(): ?Gouvernorat
    {
        return $this->gouvernorat;
    }

    public function setGouvernorat(?Gouvernorat $gouvernorat): self
    {
        $this->gouvernorat = $gouvernorat;

        return $this;
    }

    /**
     * @return Collection|Quartier[]
     */
    public function getQuartier(): Collection
    {
        return $this->quartier;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartier->contains($quartier)) {
            $this->quartier[] = $quartier;
            $quartier->setDeligation($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartier->contains($quartier)) {
            $this->quartier->removeElement($quartier);
            // set the owning side to null (unless already changed)
            if ($quartier->getDeligation() === $this) {
                $quartier->setDeligation(null);
            }
        }

        return $this;
    }
}
