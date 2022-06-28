<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RapportMarketingRepository")
 */
class RapportMarketing
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
    private $isOneToOne;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MarcConcurent", inversedBy="rapportMarketings")
     */
    private $concurrent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MarkTypeDeCompagne", inversedBy="rapportMarketings")
     */
    private $typeDeCompagnie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MarkNouvelEquipement", inversedBy="rapportMarketing")
     */
    private $nouvelEquipment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PdvTPOSM", inversedBy="rapportMarketings")
     */
    private $tposm;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RapportGlobal", inversedBy="rapportMarketing")
     */
    private $rapportGlobal;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commentaire", inversedBy="rapportMarketings")
     */
    private $commentMark;


    public function __construct()
    {
        $this->concurrent = new ArrayCollection();
        $this->typeDeCompagnie = new ArrayCollection();
        $this->tposm = new ArrayCollection();
        $this->tposm = new ArrayCollection();
        $this->commentMark = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsOneToOne(): ?bool
    {
        return $this->isOneToOne;
    }

    public function setIsOneToOne(bool $isOneToOne): self
    {
        $this->isOneToOne = $isOneToOne;

        return $this;
    }

    /**
     * @return Collection|MarcConcurent[]
     */
    public function getConcurrent(): Collection
    {
        return $this->concurrent;
    }

    public function addConcurrent(MarcConcurent $concurrent): self
    {
        if (!$this->concurrent->contains($concurrent)) {
            $this->concurrent[] = $concurrent;
        }

        return $this;
    }

    public function removeConcurrent(MarcConcurent $concurrent): self
    {
        if ($this->concurrent->contains($concurrent)) {
            $this->concurrent->removeElement($concurrent);
        }

        return $this;
    }

    public function getTypeDeCompagnie(): ?MarkTypeDeCompagne
    {
        return $this->typeDeCompagnie;
    }

    public function setTypeDeCompagnie(?MarkTypeDeCompagne $typeDeCompagnie): self
    {
        $this->typeDeCompagnie = $typeDeCompagnie;

        return $this;
    }

    public function getNouvelEquipment(): ?MarkNouvelEquipement
    {
        return $this->nouvelEquipment;
    }

    public function setNouvelEquipment(?MarkNouvelEquipement $nouvelEquipment): self
    {
        $this->nouvelEquipment = $nouvelEquipment;

        return $this;
    }

    /**
     * @return Collection|PdvTPOSM[]
     */
    public function getTposm(): Collection
    {
        return $this->tposm;
    }

    public function addTposm(PdvTPOSM $tposm): self
    {
        if (!$this->tposm->contains($tposm)) {
            $this->tposm[] = $tposm;
        }

        return $this;
    }

    public function removeTposm(PdvTPOSM $tposm): self
    {
        if ($this->tposm->contains($tposm)) {
            $this->tposm->removeElement($tposm);
        }

        return $this;
    }

    public function getRapportMaintenance(): ?RapportGlobal
    {
        return $this->RapportMaintenance;
    }

    public function getRapportGlobal(): ?RapportGlobal
    {
        return $this->rapportGlobal;
    }

    public function setRapportGlobal(?RapportGlobal $rapportGlobal): self
    {
        $this->rapportGlobal = $rapportGlobal;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentMark(): Collection
    {
        return $this->commentMark;
    }

    public function addCommentMark(Commentaire $commentMark): self
    {
        if (!$this->commentMark->contains($commentMark)) {
            $this->commentMark[] = $commentMark;
        }

        return $this;
    }

    public function removeCommentMark(Commentaire $commentMark): self
    {
        if ($this->commentMark->contains($commentMark)) {
            $this->commentMark->removeElement($commentMark);
        }

        return $this;
    }


}
