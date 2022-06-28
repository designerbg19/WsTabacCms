<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CommentaireType", inversedBy="commentaires")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="commentPdv")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RapportPPOSM", inversedBy="commentPPOSM")
     */
    private $rapportPPOSM;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RapportTlp", inversedBy="commentTlp")
     */
    private $rapportTlp;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RapportTposm", mappedBy="commentTposm")
     */
    private $rapportTposms;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RapportMaintenance", mappedBy="commentMain")
     */
    private $rapportMaintenances;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RapportMarketing", mappedBy="commentMark")
     */
    private $rapportMarketings;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RapportProduit", mappedBy="commentProduit")
     */
    private $rapportProduits;

    public function __construct()
    {
        $this->rapportTposms = new ArrayCollection();
        $this->rapportMaintenances = new ArrayCollection();
        $this->rapportMarketings = new ArrayCollection();
        $this->rapportProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getTypeCommentaire(): ?string
    {
        return $this->typeCommentaire;
    }

    public function setTypeCommentaire(string $typeCommentaire): self
    {
        $this->typeCommentaire = $typeCommentaire;

        return $this;
    }

    public function getType(): ?CommentaireType
    {
        return $this->type;
    }

    public function setType(?CommentaireType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getRapportPPOSM(): ?RapportPPOSM
    {
        return $this->rapportPPOSM;
    }

    public function setRapportPPOSM(?RapportPPOSM $rapportPPOSM): self
    {
        $this->rapportPPOSM = $rapportPPOSM;

        return $this;
    }

    public function getRapportTposm(): ?RapportTposm
    {
        return $this->rapportTposm;
    }

    public function getRapportTlp(): ?RapportTlp
    {
        return $this->rapportTlp;
    }

    public function setRapportTlp(?RapportTlp $rapportTlp): self
    {
        $this->rapportTlp = $rapportTlp;

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
            $rapportTposm->addCommentTposm($this);
        }

        return $this;
    }

    public function removeRapportTposm(RapportTposm $rapportTposm): self
    {
        if ($this->rapportTposms->contains($rapportTposm)) {
            $this->rapportTposms->removeElement($rapportTposm);
            $rapportTposm->removeCommentTposm($this);
        }

        return $this;
    }

    /**
     * @return Collection|RapportMaintenance[]
     */
    public function getRapportMaintenances(): Collection
    {
        return $this->rapportMaintenances;
    }

    public function addRapportMaintenance(RapportMaintenance $rapportMaintenance): self
    {
        if (!$this->rapportMaintenances->contains($rapportMaintenance)) {
            $this->rapportMaintenances[] = $rapportMaintenance;
            $rapportMaintenance->addCommentMain($this);
        }

        return $this;
    }

    public function removeRapportMaintenance(RapportMaintenance $rapportMaintenance): self
    {
        if ($this->rapportMaintenances->contains($rapportMaintenance)) {
            $this->rapportMaintenances->removeElement($rapportMaintenance);
            $rapportMaintenance->removeCommentMain($this);
        }

        return $this;
    }

    /**
     * @return Collection|RapportMarketing[]
     */
    public function getRapportMarketings(): Collection
    {
        return $this->rapportMarketings;
    }

    public function addRapportMarketing(RapportMarketing $rapportMarketing): self
    {
        if (!$this->rapportMarketings->contains($rapportMarketing)) {
            $this->rapportMarketings[] = $rapportMarketing;
            $rapportMarketing->addCommentMark($this);
        }

        return $this;
    }

    public function removeRapportMarketing(RapportMarketing $rapportMarketing): self
    {
        if ($this->rapportMarketings->contains($rapportMarketing)) {
            $this->rapportMarketings->removeElement($rapportMarketing);
            $rapportMarketing->removeCommentMark($this);
        }

        return $this;
    }

    /**
     * @return Collection|RapportProduit[]
     */
    public function getRapportProduits(): Collection
    {
        return $this->rapportProduits;
    }

    public function addRapportProduit(RapportProduit $rapportProduit): self
    {
        if (!$this->rapportProduits->contains($rapportProduit)) {
            $this->rapportProduits[] = $rapportProduit;
            $rapportProduit->addCommentProduit($this);
        }

        return $this;
    }

    public function removeRapportProduit(RapportProduit $rapportProduit): self
    {
        if ($this->rapportProduits->contains($rapportProduit)) {
            $this->rapportProduits->removeElement($rapportProduit);
            $rapportProduit->removeCommentProduit($this);
        }

        return $this;
    }


}
