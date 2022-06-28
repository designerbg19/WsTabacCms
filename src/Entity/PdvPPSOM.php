<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PdvPPSOMRepository")
 */
class PdvPPSOM
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
    private $ppsom;



    public function __construct()
    {
        $this->presencePpsomJtis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPpsom(): ?string
    {
        return $this->ppsom;
    }

    public function setPpsom(?string $ppsom): self
    {
        $this->ppsom = $ppsom;

        return $this;
    }

    /**
     * @return Collection|PresencePpsomJti[]
     */
    public function getPresencePpsomJtis(): Collection
    {
        return $this->presencePpsomJtis;
    }

    public function addPresencePpsomJti(PresencePpsomJti $presencePpsomJti): self
    {
        if (!$this->presencePpsomJtis->contains($presencePpsomJti)) {
            $this->presencePpsomJtis[] = $presencePpsomJti;
            $presencePpsomJti->addPdvPpsom($this);
        }

        return $this;
    }

    public function removePresencePpsomJti(PresencePpsomJti $presencePpsomJti): self
    {
        if ($this->presencePpsomJtis->contains($presencePpsomJti)) {
            $this->presencePpsomJtis->removeElement($presencePpsomJti);
            $presencePpsomJti->removePdvPpsom($this);
        }

        return $this;
    }
}
