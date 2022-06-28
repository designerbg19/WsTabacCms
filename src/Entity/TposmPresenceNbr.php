<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TposmPresenceNbrRepository")
 */
class TposmPresenceNbr
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrArticle;



    public function __construct()
    {
        $this->rapportTposms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrArticle(): ?int
    {
        return $this->nbrArticle;
    }

    public function setNbrArticle(int $nbrArticle): self
    {
        $this->nbrArticle = $nbrArticle;

        return $this;
    }

    /**
     * @return Collection|RapportTposm[]
     */
    public function getRapportTposms(): Collection
    {
        return $this->rapportTposms;
    }

    public function addRapportTposm(RapportTposm $rapportTposm): self
    {
        if (!$this->rapportTposms->contains($rapportTposm)) {
            $this->rapportTposms[] = $rapportTposm;
            $rapportTposm->setPresenceNbrArticle($this);
        }

        return $this;
    }

    public function removeRapportTposm(RapportTposm $rapportTposm): self
    {
        if ($this->rapportTposms->contains($rapportTposm)) {
            $this->rapportTposms->removeElement($rapportTposm);
            // set the owning side to null (unless already changed)
            if ($rapportTposm->getPresenceNbrArticle() === $this) {
                $rapportTposm->setPresenceNbrArticle(null);
            }
        }

        return $this;
    }
}
