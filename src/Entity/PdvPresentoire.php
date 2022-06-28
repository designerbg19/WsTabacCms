<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PdvPresentoireRepository")
 */
class PdvPresentoire
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
     * @ORM\Column(type="boolean")
     */
    private $isJti;

    /**
     * @return mixed
     */
    public function getIsJti()
    {
        return $this->isJti;
    }

    /**
     * @param mixed $isJti
     * @return PdvPresentoire
     */
    public function setIsJti($isJti)
    {
        $this->isJti = $isJti;
        return $this;
    }

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\File", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PraisontoirMaisonDeMaire", inversedBy="pdvPresentoires")
     */
    private $maisonMaire;


    public function __construct()
    {
        $this->installPresentoireJtis = new ArrayCollection();
        $this->desInstallPresentoireJtis = new ArrayCollection();
        $this->presence = new ArrayCollection();
        $this->desinstallationPresentoireNotJtis = new ArrayCollection();
        $this->presencePresentoireNotJtis = new ArrayCollection();
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



    public function getPraisontoirMaisonDeMaire(): ?PraisontoirMaisonDeMaire
    {
        return $this->praisontoirMaisonDeMaire;
    }

    public function setPraisontoirMaisonDeMaire(?PraisontoirMaisonDeMaire $praisontoirMaisonDeMaire): self
    {
        $this->praisontoirMaisonDeMaire = $praisontoirMaisonDeMaire;

        return $this;
    }

    /**
     * @return Collection|InstallPresentoireJti[]
     */
    public function getInstallPresentoireJtis(): Collection
    {
        return $this->installPresentoireJtis;
    }

    public function addInstallPresentoireJti(InstallPresentoireJti $installPresentoireJti): self
    {
        if (!$this->installPresentoireJtis->contains($installPresentoireJti)) {
            $this->installPresentoireJtis[] = $installPresentoireJti;
            $installPresentoireJti->setPresentoire($this);
        }

        return $this;
    }

    public function removeInstallPresentoireJti(InstallPresentoireJti $installPresentoireJti): self
    {
        if ($this->installPresentoireJtis->contains($installPresentoireJti)) {
            $this->installPresentoireJtis->removeElement($installPresentoireJti);
            // set the owning side to null (unless already changed)
            if ($installPresentoireJti->getPresentoire() === $this) {
                $installPresentoireJti->setPresentoire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DesInstallPresentoireJti[]
     */
    public function getDesInstallPresentoireJtis(): Collection
    {
        return $this->desInstallPresentoireJtis;
    }

    public function addDesInstallPresentoireJti(DesInstallPresentoireJti $desInstallPresentoireJti): self
    {
        if (!$this->desInstallPresentoireJtis->contains($desInstallPresentoireJti)) {
            $this->desInstallPresentoireJtis[] = $desInstallPresentoireJti;
            $desInstallPresentoireJti->setPresentoire($this);
        }

        return $this;
    }

    public function removeDesInstallPresentoireJti(DesInstallPresentoireJti $desInstallPresentoireJti): self
    {
        if ($this->desInstallPresentoireJtis->contains($desInstallPresentoireJti)) {
            $this->desInstallPresentoireJtis->removeElement($desInstallPresentoireJti);
            // set the owning side to null (unless already changed)
            if ($desInstallPresentoireJti->getPresentoire() === $this) {
                $desInstallPresentoireJti->setPresentoire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PresencePresentoireJti[]
     */
    public function getPresencePresentoireJtis(): Collection
    {
        return $this->presencePresentoireJtis;
    }

    public function addPresencePresentoireJti(PresencePresentoireJti $presencePresentoireJti): self
    {
        if (!$this->presencePresentoireJtis->contains($presencePresentoireJti)) {
            $this->presencePresentoireJtis[] = $presencePresentoireJti;
            $presencePresentoireJti->addPresentoire($this);
        }

        return $this;
    }

    public function removePresencePresentoireJti(PresencePresentoireJti $presencePresentoireJti): self
    {
        if ($this->presencePresentoireJtis->contains($presencePresentoireJti)) {
            $this->presencePresentoireJtis->removeElement($presencePresentoireJti);
            $presencePresentoireJti->removePresentoire($this);
        }

        return $this;
    }

    /**
     * @return Collection|PresencePresentoireJti[]
     */
    public function getPresence(): Collection
    {
        return $this->presence;
    }

    public function addPresence(PresencePresentoireJti $presence): self
    {
        if (!$this->presence->contains($presence)) {
            $this->presence[] = $presence;
            $presence->setPdvPresentoire($this);
        }

        return $this;
    }

    public function removePresence(PresencePresentoireJti $presence): self
    {
        if ($this->presence->contains($presence)) {
            $this->presence->removeElement($presence);
            // set the owning side to null (unless already changed)
            if ($presence->getPdvPresentoire() === $this) {
                $presence->setPdvPresentoire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DesinstallationPresentoireNotJti[]
     */
    public function getDesinstallationPresentoireNotJtis(): Collection
    {
        return $this->desinstallationPresentoireNotJtis;
    }

    public function addDesinstallationPresentoireNotJti(DesinstallationPresentoireNotJti $desinstallationPresentoireNotJti): self
    {
        if (!$this->desinstallationPresentoireNotJtis->contains($desinstallationPresentoireNotJti)) {
            $this->desinstallationPresentoireNotJtis[] = $desinstallationPresentoireNotJti;
            $desinstallationPresentoireNotJti->setPresentoire($this);
        }

        return $this;
    }

    public function removeDesinstallationPresentoireNotJti(DesinstallationPresentoireNotJti $desinstallationPresentoireNotJti): self
    {
        if ($this->desinstallationPresentoireNotJtis->contains($desinstallationPresentoireNotJti)) {
            $this->desinstallationPresentoireNotJtis->removeElement($desinstallationPresentoireNotJti);
            // set the owning side to null (unless already changed)
            if ($desinstallationPresentoireNotJti->getPresentoire() === $this) {
                $desinstallationPresentoireNotJti->setPresentoire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PresencePresentoireNotJti[]
     */
    public function getPresencePresentoireNotJtis(): Collection
    {
        return $this->presencePresentoireNotJtis;
    }

    public function addPresencePresentoireNotJti(PresencePresentoireNotJti $presencePresentoireNotJti): self
    {
        if (!$this->presencePresentoireNotJtis->contains($presencePresentoireNotJti)) {
            $this->presencePresentoireNotJtis[] = $presencePresentoireNotJti;
            $presencePresentoireNotJti->addPdvPresentoire($this);
        }

        return $this;
    }

    public function removePresencePresentoireNotJti(PresencePresentoireNotJti $presencePresentoireNotJti): self
    {
        if ($this->presencePresentoireNotJtis->contains($presencePresentoireNotJti)) {
            $this->presencePresentoireNotJtis->removeElement($presencePresentoireNotJti);
            $presencePresentoireNotJti->removePdvPresentoire($this);
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

    public function getMaisonMaire(): ?PraisontoirMaisonDeMaire
    {
        return $this->maisonMaire;
    }

    public function setMaisonMaire(?PraisontoirMaisonDeMaire $maisonMaire): self
    {
        $this->maisonMaire = $maisonMaire;

        return $this;
    }
   }
