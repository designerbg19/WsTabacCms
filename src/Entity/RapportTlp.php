<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RapportTlpRepository")
 */
class RapportTlp
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPlanogramme;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEclairage;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TlpStokeCourant", inversedBy="rapportTlps")
     */
    private $stockeCourant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="rapportTlp")
     */
    private $commentTlp;

    public function __construct()
    {
        $this->stockeCourant = new ArrayCollection();
        $this->commentTlp = new ArrayCollection();
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsPlanogramme(): ?bool
    {
        return $this->isPlanogramme;
    }

    public function setIsPlanogramme(bool $isPlanogramme): self
    {
        $this->isPlanogramme = $isPlanogramme;

        return $this;
    }

    public function getIsEclairage(): ?bool
    {
        return $this->isEclairage;
    }

    public function setIsEclairage(bool $isEclairage): self
    {
        $this->isEclairage = $isEclairage;

        return $this;
    }

    /**
     * @return Collection|TlpStokeCourant[]
     */
    public function getStockeCourant(): Collection
    {
        return $this->stockeCourant;
    }

    public function addStockeCourant(TlpStokeCourant $stockeCourant): self
    {
        if (!$this->stockeCourant->contains($stockeCourant)) {
            $this->stockeCourant[] = $stockeCourant;
        }

        return $this;
    }

    public function removeStockeCourant(TlpStokeCourant $stockeCourant): self
    {
        if ($this->stockeCourant->contains($stockeCourant)) {
            $this->stockeCourant->removeElement($stockeCourant);
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentTlp(): Collection
    {
        return $this->commentTlp;
    }

    public function addCommentTlp(Commentaire $commentTlp): self
    {
        if (!$this->commentTlp->contains($commentTlp)) {
            $this->commentTlp[] = $commentTlp;
            $commentTlp->setRapportTlp($this);
        }

        return $this;
    }

    public function removeCommentTlp(Commentaire $commentTlp): self
    {
        if ($this->commentTlp->contains($commentTlp)) {
            $this->commentTlp->removeElement($commentTlp);
            // set the owning side to null (unless already changed)
            if ($commentTlp->getRapportTlp() === $this) {
                $commentTlp->setRapportTlp(null);
            }
        }

        return $this;
    }



}
