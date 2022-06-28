<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RapportPPOSMRepository")
 */
class RapportPPOSM
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRapport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="rapportPPOSMs")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Merch", inversedBy="rapportPPOSMs")
     */
    private $merch;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InstallPresentoireJti", inversedBy="rapportPPOSMs")
     */
    private $install_presentoire_jti;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DesInstallPresentoireJti", inversedBy="rapportPPOSMs")
     */
    private $des_install_presentoire_jti;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PresencePresentoireJti", inversedBy="rapportPPOSMs")
     */
    private $presencePresentoireJti;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PresencePpsomJti", inversedBy="rapportPPOSMs")
     */
    private $presence_ppsom_jt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PresenceShopJti", inversedBy="rapportPPOSMs")
     */
    private $presenceShopJti;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PresencePresentoireNotJti", inversedBy="rapportPPOSMs")
     */
    private $presencePresentoireNotJti;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PlvTemporaire", inversedBy="rapportPPOSMs")
     */
    private $plvTemporaire;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DesinstallationPresentoireNotJti", inversedBy="rapportPPOSMs")
     */
    private $desIntallPresentoireNotJti;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="rapportPPOSM")
     */
    private $commentPPOSM;



    public function __construct()
    {
        $this->presence_ppsom_jt = new ArrayCollection();
        $this->presenceShopJti = new ArrayCollection();
        $this->presencePresentoireNotJti = new ArrayCollection();
        $this->plvTemporaire = new ArrayCollection();
        $this->desIntallPresentoireNotJti = new ArrayCollection();
        $this->commentPPOSM = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRapport(): ?\DateTimeInterface
    {
        return $this->dateRapport;
    }

    public function setDateRapport(\DateTimeInterface $dateRapport): self
    {
        $this->dateRapport = $dateRapport;

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



    public function getInstallPresentoireJti(): ?InstallPresentoireJti
    {
        return $this->install_presentoire_jti;
    }

    public function setInstallPresentoireJti(?InstallPresentoireJti $install_presentoire_jti): self
    {
        $this->install_presentoire_jti = $install_presentoire_jti;

        return $this;
    }

    public function getDesInstallPresentoireJti(): ?DesInstallPresentoireJti
    {
        return $this->des_install_presentoire_jti;
    }

    public function setDesInstallPresentoireJti(?DesInstallPresentoireJti $des_install_presentoire_jti): self
    {
        $this->des_install_presentoire_jti = $des_install_presentoire_jti;

        return $this;
    }

    public function getPresencePresentoireJti(): ?PresencePresentoireJti
    {
        return $this->presencePresentoireJti;
    }

    public function setPresencePresentoireJti(?PresencePresentoireJti $presencePresentoireJti): self
    {
        $this->presencePresentoireJti = $presencePresentoireJti;

        return $this;
    }

    public function getPlvTemporaire(): ?PlvTemporaire
    {
        return $this->plvTemporaire;
    }

    public function setPlvTemporaire(?PlvTemporaire $plvTemporaire): self
    {
        $this->plvTemporaire = $plvTemporaire;

        return $this;
    }



    /**
     * @return Collection|PresencePpsomJti[]
     */
    public function getPresencePpsomJt(): Collection
    {
        return $this->presence_ppsom_jt;
    }

    public function addPresencePpsomJt(PresencePpsomJti $presencePpsomJt): self
    {
        if (!$this->presence_ppsom_jt->contains($presencePpsomJt)) {
            $this->presence_ppsom_jt[] = $presencePpsomJt;
        }

        return $this;
    }

    public function removePresencePpsomJt(PresencePpsomJti $presencePpsomJt): self
    {
        if ($this->presence_ppsom_jt->contains($presencePpsomJt)) {
            $this->presence_ppsom_jt->removeElement($presencePpsomJt);
        }

        return $this;
    }

    /**
     * @return Collection|PresenceShopJti[]
     */
    public function getPresenceShopJti(): Collection
    {
        return $this->presenceShopJti;
    }

    public function addPresenceShopJti(PresenceShopJti $presenceShopJti): self
    {
        if (!$this->presenceShopJti->contains($presenceShopJti)) {
            $this->presenceShopJti[] = $presenceShopJti;
        }

        return $this;
    }

    public function removePresenceShopJti(PresenceShopJti $presenceShopJti): self
    {
        if ($this->presenceShopJti->contains($presenceShopJti)) {
            $this->presenceShopJti->removeElement($presenceShopJti);
        }

        return $this;
    }

    /**
     * @return Collection|PresencePresentoireNotJti[]
     */
    public function getPresencePresentoireNotJti(): Collection
    {
        return $this->presencePresentoireNotJti;
    }

    public function addPresencePresentoireNotJti(PresencePresentoireNotJti $presencePresentoireNotJti): self
    {
        if (!$this->presencePresentoireNotJti->contains($presencePresentoireNotJti)) {
            $this->presencePresentoireNotJti[] = $presencePresentoireNotJti;
        }

        return $this;
    }

    public function removePresencePresentoireNotJti(PresencePresentoireNotJti $presencePresentoireNotJti): self
    {
        if ($this->presencePresentoireNotJti->contains($presencePresentoireNotJti)) {
            $this->presencePresentoireNotJti->removeElement($presencePresentoireNotJti);
        }

        return $this;
    }

    public function addPlvTemporaire(PlvTemporaire $plvTemporaire): self
    {
        if (!$this->plvTemporaire->contains($plvTemporaire)) {
            $this->plvTemporaire[] = $plvTemporaire;
        }

        return $this;
    }

    public function removePlvTemporaire(PlvTemporaire $plvTemporaire): self
    {
        if ($this->plvTemporaire->contains($plvTemporaire)) {
            $this->plvTemporaire->removeElement($plvTemporaire);
        }

        return $this;
    }

    /**
     * @return Collection|DesinstallationPresentoireNotJti[]
     */
    public function getDesIntallPresentoireNotJti(): Collection
    {
        return $this->desIntallPresentoireNotJti;
    }

    public function addDesIntallPresentoireNotJti(DesinstallationPresentoireNotJti $desIntallPresentoireNotJti): self
    {
        if (!$this->desIntallPresentoireNotJti->contains($desIntallPresentoireNotJti)) {
            $this->desIntallPresentoireNotJti[] = $desIntallPresentoireNotJti;
        }

        return $this;
    }

    public function removeDesIntallPresentoireNotJti(DesinstallationPresentoireNotJti $desIntallPresentoireNotJti): self
    {
        if ($this->desIntallPresentoireNotJti->contains($desIntallPresentoireNotJti)) {
            $this->desIntallPresentoireNotJti->removeElement($desIntallPresentoireNotJti);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerch()
    {
        return $this->merch;
    }

    /**
     * @param mixed $merch
     * @return RapportPPOSM
     */
    public function setMerch($merch)
    {
        $this->merch = $merch;
        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentPPOSM(): Collection
    {
        return $this->commentPPOSM;
    }

    public function addCommentPPOSM(Commentaire $commentPPOSM): self
    {
        if (!$this->commentPPOSM->contains($commentPPOSM)) {
            $this->commentPPOSM[] = $commentPPOSM;
            $commentPPOSM->setRapportPPOSM($this);
        }

        return $this;
    }

    public function removeCommentPPOSM(Commentaire $commentPPOSM): self
    {
        if ($this->commentPPOSM->contains($commentPPOSM)) {
            $this->commentPPOSM->removeElement($commentPPOSM);
            // set the owning side to null (unless already changed)
            if ($commentPPOSM->getRapportPPOSM() === $this) {
                $commentPPOSM->setRapportPPOSM(null);
            }
        }

        return $this;
    }

}
