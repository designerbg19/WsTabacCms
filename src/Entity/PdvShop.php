<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PdvShopRepository")
 */
class PdvShop
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
    private $shop;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\File", cascade={"persist", "remove"})
     */
    private $image;



    public function __construct()
    {
        $this->presenceShopJtis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShop(): ?string
    {
        return $this->shop;
    }

    public function setShop(?string $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * @return Collection|PresenceShopJti[]
     */
    public function getPresenceShopJtis(): Collection
    {
        return $this->presenceShopJtis;
    }

    public function addPresenceShopJti(PresenceShopJti $presenceShopJti): self
    {
        if (!$this->presenceShopJtis->contains($presenceShopJti)) {
            $this->presenceShopJtis[] = $presenceShopJti;
            $presenceShopJti->addPdvshop($this);
        }

        return $this;
    }

    public function removePresenceShopJti(PresenceShopJti $presenceShopJti): self
    {
        if ($this->presenceShopJtis->contains($presenceShopJti)) {
            $this->presenceShopJtis->removeElement($presenceShopJti);
            $presenceShopJti->removePdvshop($this);
        }

        return $this;
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    public function setImage(?File $image): self
    {
        $this->image = $image;

        return $this;
    }
}
