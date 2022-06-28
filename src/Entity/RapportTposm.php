<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RapportTposmRepository")
 */
class RapportTposm
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
    private $isPresent;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInstall;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TposmPresenceNbr", inversedBy="rapportTposms")
     */
    private $presenceNbrArticle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TposmInstalationNbr", inversedBy="rapportTposms")
     */
    private $installationNbr;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TposmRaisonRefus", inversedBy="rapportTposms")
     */
    private $instalationRaison;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commentaire", inversedBy="rapportTposms")
     */
    private $commentTposm;



    public function __construct()
    {
        $this->commentTposm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsPresent(): ?bool
    {
        return $this->isPresent;
    }

    public function setIsPresent(bool $isPresent): self
    {
        $this->isPresent = $isPresent;

        return $this;
    }

    public function getIsInstall(): ?bool
    {
        return $this->isInstall;
    }

    public function setIsInstall(bool $isInstall): self
    {
        $this->isInstall = $isInstall;

        return $this;
    }

    public function getPresenceNbrArticle(): ?TposmPresenceNbr
    {
        return $this->presenceNbrArticle;
    }

    public function setPresenceNbrArticle(?TposmPresenceNbr $presenceNbrArticle): self
    {
        $this->presenceNbrArticle = $presenceNbrArticle;

        return $this;
    }

    public function getInstallationNbr(): ?TposmInstalationNbr
    {
        return $this->installationNbr;
    }

    public function setInstallationNbr(?TposmInstalationNbr $installationNbr): self
    {
        $this->installationNbr = $installationNbr;

        return $this;
    }

    public function getInstalationRaison(): ?TposmRaisonRefus
    {
        return $this->instalationRaison;
    }

    public function setInstalationRaison(?TposmRaisonRefus $instalationRaison): self
    {
        $this->instalationRaison = $instalationRaison;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentTposm(): Collection
    {
        return $this->commentTposm;
    }

    public function addCommentTposm(Commentaire $commentTposm): self
    {
        if (!$this->commentTposm->contains($commentTposm)) {
            $this->commentTposm[] = $commentTposm;
        }

        return $this;
    }

    public function removeCommentTposm(Commentaire $commentTposm): self
    {
        if ($this->commentTposm->contains($commentTposm)) {
            $this->commentTposm->removeElement($commentTposm);
        }

        return $this;
    }


}
