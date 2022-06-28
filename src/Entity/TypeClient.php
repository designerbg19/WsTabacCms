<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeClientRepository")
 */
class TypeClient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $type;



    public function __construct()
    {
        $this->infoClient = new ArrayCollection();
        $this->infoClients = new ArrayCollection();
   }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|InfoClient[]
     */
    public function getInfoClient(): Collection
    {
        return $this->infoClient;
    }

    public function addInfoClient(InfoClient $infoClient): self
    {
        if (!$this->infoClient->contains($infoClient)) {
            $this->infoClient[] = $infoClient;
            $infoClient->setTypeClient($this);
        }

        return $this;
    }

    public function removeInfoClient(InfoClient $infoClient): self
    {
        if ($this->infoClient->contains($infoClient)) {
            $this->infoClient->removeElement($infoClient);
            // set the owning side to null (unless already changed)
            if ($infoClient->getTypeClient() === $this) {
                $infoClient->setTypeClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InfoClient[]
     */
    public function getInfoClients(): Collection
    {
        return $this->infoClients;
    }

   }
