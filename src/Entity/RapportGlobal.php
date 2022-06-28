<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RapportGlobalRepository")
 */
class RapportGlobal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Client", cascade={"persist", "remove"})
     */
    private $RapportPdv;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\RapportPPOSM", cascade={"persist", "remove"})
     */
    private $RapportPPOSM;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\RapportTposm", cascade={"persist", "remove"})
     */
    private $RapportTPOSM;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\RapportTlp", cascade={"persist", "remove"})
     */
    private $RapportTlp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RapportProduit", mappedBy="rapportGlobal")
     */
    private $RapportProduit;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RapportMarketing", mappedBy="rapportGlobal")
     */
    private $rapportMarketing;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RapportMaintenance", mappedBy="rapportGlobal")
     */
    private $rapportMaintenance;

    /**
     *  @ORM\Column(type="datetime",nullable=true)
     */
    private $dateRappoort;

    /**
     * @return mixed
     */
    public function getDateRappoort()
    {
        return $this->dateRappoort;
    }

    /**
     * @param mixed $dateRappoort
     */
    public function setDateRappoort($dateRappoort): void
    {
        $this->dateRappoort = $dateRappoort;
    }

    /**
     * @return mixed
     */
    public function getDurre()
    {
        return $this->durre;
    }

    /**
     * @param mixed $durre
     */
    public function setDurre($durre): void
    {
        $this->durre = $durre;
    }
    /**
     * @ORM\Column(type="string", length=255,nullable=true,nullable=true)
     */
    private $durre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Merch")
     */
    private $merch;

    public function __construct()
    {
        $this->RapportProduit = new ArrayCollection();
        $this->rapportMarketing = new ArrayCollection();
        $this->rapportMaintenance = new ArrayCollection();
        $this->dateRappoort = new \DateTime('NOW');

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRapportPdv(): ?Client
    {
        return $this->RapportPdv;
    }

    public function setRapportPdv(?Client $RapportPdv): self
    {
        $this->RapportPdv = $RapportPdv;

        return $this;
    }

    public function getRapportPPOSM(): ?RapportPPOSM
    {
        return $this->RapportPPOSM;
    }

    public function setRapportPPOSM(?RapportPPOSM $RapportPPOSM): self
    {
        $this->RapportPPOSM = $RapportPPOSM;

        return $this;
    }

    public function getRapportTPOSM(): ?RapportTposm
    {
        return $this->RapportTPOSM;
    }

    public function setRapportTPOSM(?RapportTposm $RapportTPOSM): self
    {
        $this->RapportTPOSM = $RapportTPOSM;

        return $this;
    }

    public function getRapportTlp(): ?RapportTlp
    {
        return $this->RapportTlp;
    }

    public function setRapportTlp(?RapportTlp $RapportTlp): self
    {
        $this->RapportTlp = $RapportTlp;

        return $this;
    }

    /**
     * @return Collection|RapportProduit[]
     */
    public function getRapportProduit(): Collection
    {
        return $this->RapportProduit;
    }

    public function addRapportProduit(RapportProduit $rapportProduit): self
    {
        if (!$this->RapportProduit->contains($rapportProduit)) {
            $this->RapportProduit[] = $rapportProduit;
            $rapportProduit->setRapportGlobal($this);
        }

        return $this;
    }

    public function removeRapportProduit(RapportProduit $rapportProduit): self
    {
        if ($this->RapportProduit->contains($rapportProduit)) {
            $this->RapportProduit->removeElement($rapportProduit);
            // set the owning side to null (unless already changed)
            if ($rapportProduit->getRapportGlobal() === $this) {
                $rapportProduit->setRapportGlobal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RapportMarketing[]
     */
    public function getRapportMarketing(): Collection
    {
        return $this->rapportMarketing;
    }

    public function addRapportMarketing(RapportMarketing $rapportMarketing): self
    {
        if (!$this->rapportMarketing->contains($rapportMarketing)) {
            $this->rapportMarketing[] = $rapportMarketing;
            $rapportMarketing->setRapportGlobal($this);
        }

        return $this;
    }

    public function removeRapportMarketing(RapportMarketing $rapportMarketing): self
    {
        if ($this->rapportMarketing->contains($rapportMarketing)) {
            $this->rapportMarketing->removeElement($rapportMarketing);
            // set the owning side to null (unless already changed)
            if ($rapportMarketing->getRapportGlobal() === $this) {
                $rapportMarketing->setRapportGlobal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RapportMaintenance[]
     */
    public function getRapportMaintenance(): Collection
    {
        return $this->rapportMaintenance;
    }

    public function addRapportMaintenance(RapportMaintenance $rapportMaintenance): self
    {
        if (!$this->rapportMaintenance->contains($rapportMaintenance)) {
            $this->rapportMaintenance[] = $rapportMaintenance;
            $rapportMaintenance->setRapportGlobal($this);
        }

        return $this;
    }

    public function removeRapportMaintenance(RapportMaintenance $rapportMaintenance): self
    {
        if ($this->rapportMaintenance->contains($rapportMaintenance)) {
            $this->rapportMaintenance->removeElement($rapportMaintenance);
            // set the owning side to null (unless already changed)
            if ($rapportMaintenance->getRapportGlobal() === $this) {
                $rapportMaintenance->setRapportGlobal(null);
            }
        }

        return $this;
    }

    public function getMerch(): ?Merch
    {
        return $this->merch;
    }

    public function setMerch(?Merch $merch): self
    {
        $this->merch = $merch;

        return $this;
    }




}
