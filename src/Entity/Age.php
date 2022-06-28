<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgeRepository")
 */
class Age
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
    private $age;



    public function __construct()
    {
        $this->infoClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(?string $age): self
    {
        $this->age = $age;

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
            $infoClient->setAgeClient($this);
        }

        return $this;
    }

    public function removeInfoClient(InfoClient $infoClient): self
    {
        if ($this->infoClients->contains($infoClient)) {
            $this->infoClients->removeElement($infoClient);
            // set the owning side to null (unless already changed)
            if ($infoClient->getAgeClient() === $this) {
                $infoClient->setAgeClient(null);
            }
        }

        return $this;
    }
}
