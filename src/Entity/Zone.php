<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ZoneRepository")
 */
class Zone
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="zone")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gouvernorat", mappedBy="zone")
     */
    private $gouvernorat;

    public function __construct()
    {
        $this->gouvernorat = new ArrayCollection();
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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection|Gouvernorat[]
     */
    public function getGouvernorat(): Collection
    {
        return $this->gouvernorat;
    }

    public function addGouvernorat(Gouvernorat $gouvernorat): self
    {
        if (!$this->gouvernorat->contains($gouvernorat)) {
            $this->gouvernorat[] = $gouvernorat;
            $gouvernorat->setZone($this);
        }

        return $this;
    }

    public function removeGouvernorat(Gouvernorat $gouvernorat): self
    {
        if ($this->gouvernorat->contains($gouvernorat)) {
            $this->gouvernorat->removeElement($gouvernorat);
            // set the owning side to null (unless already changed)
            if ($gouvernorat->getZone() === $this) {
                $gouvernorat->setZone(null);
            }
        }

        return $this;
    }
}
