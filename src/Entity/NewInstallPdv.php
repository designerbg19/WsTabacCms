<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewInstallPdvRepository")
 */
class NewInstallPdv
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
    private $statusNewInstall;

    /**
     * @ORM\Column(type="integer")
     */
    private $merchId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $newInstallDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * NewInstallPdv constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->newInstallDate = new \DateTime('NOW');
        $this->createdAt = new \DateTime('NOW');
        $this->newInstallComments = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="decimal")
     */
    private $longitude;

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @ORM\Column(type="decimal")
     */
    private $latitude;


    /**
     * @return mixed
     */
    public function getStatusNewInstall()
    {
        return $this->statusNewInstall;
    }

    /**
     * @param mixed $statusNewInstall
     */
    public function setStatusNewInstall($statusNewInstall): void
    {
        $this->statusNewInstall = $statusNewInstall;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMerchId(): ?int
    {
        return $this->merchId;
    }

    public function setMerchId(int $merchId): self
    {
        $this->merchId = $merchId;

        return $this;
    }

    public function getNewInstallDate(): ?\DateTimeInterface
    {
        return $this->newInstallDate;
    }

    public function setNewInstallDate(\DateTimeInterface $newInstallDate): self
    {
        $this->newInstallDate = $newInstallDate;

        return $this;
    }



    /**
     * @ORM\Column(type="integer", length=255,nullable=true)
     */
    private $codeClient;

    /**
     * @return mixed
     */
    public function getCodeClient()
    {
        return $this->codeClient;
    }

    /**
     * @param mixed $codeClient
     */
    public function setCodeClient($codeClient): void
    {
        $this->codeClient = $codeClient;
    }

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $licence;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer")
     */
    private $decideurId;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $titulairenom;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $titulairetel;

    /**
     * @ORM\Column(type="integer")
     */
    private $titulairesituationId;

    /**
     * @ORM\Column(type="integer")
     */
    private $titulairenbrenfId;

    /**
     * @ORM\Column(type="integer")
     */
    private $titulaireageId;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $gerantnom;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $geranttel;

    /**
     * @ORM\Column(type="integer")
     */
    private $gerantsituationId;

    /**
     * @ORM\Column(type="integer")
     */
    private $gerantnbrenfId;

    /**
     * @ORM\Column(type="integer")
     */
    private $gerantageId;



    /**
     * @return mixed
     */
    public function getLicence()
    {
        return $this->licence;
    }

    /**
     * @param mixed $licence
     */
    public function setLicence($licence): void
    {
        $this->licence = $licence;
    }

    /**
     * @return mixed
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param mixed $adress
     */
    public function setAdress($adress): void
    {
        $this->adress = $adress;
    }

    /**
     * @return mixed
     */
    public function getDecideurId()
    {
        return $this->decideurId;
    }

    /**
     * @param mixed $decideurId
     */
    public function setDecideurId($decideurId): void
    {
        $this->decideurId = $decideurId;
    }

    /**
     * @return mixed
     */
    public function getTitulairenom()
    {
        return $this->titulairenom;
    }

    /**
     * @param mixed $titulairenom
     */
    public function setTitulairenom($titulairenom): void
    {
        $this->titulairenom = $titulairenom;
    }

    /**
     * @return mixed
     */
    public function getTitulairetel()
    {
        return $this->titulairetel;
    }

    /**
     * @param mixed $titulairetel
     */
    public function setTitulairetel($titulairetel): void
    {
        $this->titulairetel = $titulairetel;
    }

    /**
     * @return mixed
     */
    public function getTitulairesituationId()
    {
        return $this->titulairesituationId;
    }

    /**
     * @param mixed $titulairesituationId
     */
    public function setTitulairesituationId($titulairesituationId): void
    {
        $this->titulairesituationId = $titulairesituationId;
    }

    /**
     * @return mixed
     */
    public function getTitulairenbrenfId()
    {
        return $this->titulairenbrenfId;
    }

    /**
     * @param mixed $titulairenbrenfId
     */
    public function setTitulairenbrenfId($titulairenbrenfId): void
    {
        $this->titulairenbrenfId = $titulairenbrenfId;
    }

    /**
     * @return mixed
     */
    public function getTitulaireageId()
    {
        return $this->titulaireageId;
    }

    /**
     * @param mixed $titulaireageId
     */
    public function setTitulaireageId($titulaireageId): void
    {
        $this->titulaireageId = $titulaireageId;
    }

    /**
     * @return mixed
     */
    public function getGerantnom()
    {
        return $this->gerantnom;
    }

    /**
     * @param mixed $gerantnom
     */
    public function setGerantnom($gerantnom): void
    {
        $this->gerantnom = $gerantnom;
    }

    /**
     * @return mixed
     */
    public function getGeranttel()
    {
        return $this->geranttel;
    }

    /**
     * @param mixed $geranttel
     */
    public function setGeranttel($geranttel): void
    {
        $this->geranttel = $geranttel;
    }

    /**
     * @return mixed
     */
    public function getGerantsituationId()
    {
        return $this->gerantsituationId;
    }

    /**
     * @param mixed $gerantsituationId
     */
    public function setGerantsituationId($gerantsituationId): void
    {
        $this->gerantsituationId = $gerantsituationId;
    }

    /**
     * @return mixed
     */
    public function getGerantnbrenfId()
    {
        return $this->gerantnbrenfId;
    }

    /**
     * @param mixed $gerantnbrenfId
     */
    public function setGerantnbrenfId($gerantnbrenfId): void
    {
        $this->gerantnbrenfId = $gerantnbrenfId;
    }

    /**
     * @return mixed
     */
    public function getGerantageId()
    {
        return $this->gerantageId;
    }

    /**
     * @param mixed $gerantageId
     */
    public function setGerantageId($gerantageId): void
    {
        $this->gerantageId = $gerantageId;
    }

    /**
     * @return mixed
     */
    public function getOperateurnom()
    {
        return $this->operateurnom;
    }

    /**
     * @param mixed $operateurnom
     */
    public function setOperateurnom($operateurnom): void
    {
        $this->operateurnom = $operateurnom;
    }

    /**
     * @return mixed
     */
    public function getOperateurtel()
    {
        return $this->operateurtel;
    }

    /**
     * @param mixed $operateurtel
     */
    public function setOperateurtel($operateurtel): void
    {
        $this->operateurtel = $operateurtel;
    }

    /**
     * @return mixed
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     * @param mixed $regionId
     */
    public function setRegionId($regionId): void
    {
        $this->regionId = $regionId;
    }

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $operateurnom;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $operateurtel;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $cin;

    /**
     * @return mixed
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @param mixed $cin
     */
    public function setCin($cin): void
    {
        $this->cin = $cin;
    }

    /**
     * @return mixed
     */
    public function getZoneId()
    {
        return $this->zoneId;
    }

    /**
     * @param mixed $zoneId
     */
    public function setZoneId($zoneId): void
    {
        $this->zoneId = $zoneId;
    }

    /**
     * @return mixed
     */
    public function getGouvernoratId()
    {
        return $this->gouvernoratId;
    }

    /**
     * @param mixed $gouvernoratId
     */
    public function setGouvernoratId($gouvernoratId): void
    {
        $this->gouvernoratId = $gouvernoratId;
    }

    /**
     * @return mixed
     */
    public function getDelegationId()
    {
        return $this->delegationId;
    }

    /**
     * @param mixed $delegatioId
     */
    public function setDelegationId($delegationId): void
    {
        $this->delegationId = $delegationId;
    }

    /**
     * @return mixed
     */
    public function getQuartierId()
    {
        return $this->quartierId;
    }

    /**
     * @param mixed $quartierId
     */
    public function setQuartierId($quartierId): void
    {
        $this->quartierId = $quartierId;
    }

    /**
     * @return mixed
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param mixed $codePostal
     */
    public function setCodePostal($codePostal): void
    {
        $this->codePostal = $codePostal;
    }

    /**
     * @return mixed
     */
    public function getSuperficieId()
    {
        return $this->superficieId;
    }

    /**
     * @param mixed $superficieId
     */
    public function setSuperficieId($superficieId): void
    {
        $this->superficieId = $superficieId;
    }

    /**
     * @return mixed
     */
    public function getNbremployesId()
    {
        return $this->nbremployesId;
    }

    /**
     * @param mixed $nbremployesId
     */
    public function setNbremployesId($nbremployesId): void
    {
        $this->nbremployesId = $nbremployesId;
    }

    /**
     * @return mixed
     */
    public function getEmplacementId()
    {
        return $this->emplacementId;
    }

    /**
     * @param mixed $emplacementId
     */
    public function setEmplacementId($emplacementId): void
    {
        $this->emplacementId = $emplacementId;
    }

    /**
     * @return mixed
     */
    public function getEnvironnementId()
    {
        return $this->environnementId;
    }

    /**
     * @param mixed $environnementId
     */
    public function setEnvironnementId($environnementId): void
    {
        $this->environnementId = $environnementId;
    }

    /**
     * @return mixed
     */
    public function getTypequartierId()
    {
        return $this->typequartierId;
    }

    /**
     * @param mixed $typequartierId
     */
    public function setTypequartierId($typequartierId): void
    {
        $this->typequartierId = $typequartierId;
    }

    /**
     * @return mixed
     */
    public function getVisibiliteId()
    {
        return $this->visibiliteId;
    }

    /**
     * @param mixed $visibiliteId
     */
    public function setVisibiliteId($visibiliteId): void
    {
        $this->visibiliteId = $visibiliteId;
    }

    /**
     * @return mixed
     */
    public function getClasseId()
    {
        return $this->classeId;
    }

    /**
     * @param mixed $classeId
     */
    public function setClasseId($classeId): void
    {
        $this->classeId = $classeId;
    }

    /**
     * @return mixed
     */
    public function getTypologieId()
    {
        return $this->typologieId;
    }

    /**
     * @param mixed $typologieId
     */
    public function setTypologieId($typologieId): void
    {
        $this->typologieId = $typologieId;
    }

    /**
     * @return mixed
     */
    public function getIsAccessPdv()
    {
        return $this->isAccessPdv;
    }

    /**
     * @param mixed $isAccessPdv
     */
    public function setIsAccessPdv($isAccessPdv): void
    {
        $this->isAccessPdv = $isAccessPdv;
    }

    /**
     * @return mixed
     */
    public function getPresentoirJtiId()
    {
        return $this->presentoirJtiId;
    }

    /**
     * @param mixed $presentoirJtiId
     */
    public function setPresentoirJtiId($presentoirJtiId): void
    {
        $this->presentoirJtiId = $presentoirJtiId;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $regionId;


    /**
     * @ORM\Column(type="integer")
     */
    private $visibility;

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility): void
    {
        $this->visibility = $visibility;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $zoneId;

    /**
     * @ORM\Column(type="integer")
     */
    private $gouvernoratId;

    /**
     * @ORM\Column(type="integer")
     */
    private $delegationId;

    /**
     * @ORM\Column(type="integer")
     */
    private $quartierId;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="integer")
     */
    private $superficieId;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbremployesId;

    /**
     * @ORM\Column(type="integer")
     */
    private $emplacementId;

    /**
     * @ORM\Column(type="integer")
     */
    private $environnementId;

    /**
     * @ORM\Column(type="integer")
     */
    private $typequartierId;

    /**
     * @ORM\Column(type="integer")
     */
    private $visibiliteId;

    /**
     * @ORM\Column(type="integer")
     */
    private $classeId;

    /**
     * @ORM\Column(type="integer")
     */
    private $typologieId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAccessPdv;

    /**
     * @ORM\Column(type="integer")
     */
    private $presentoirJtiId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOnetoone;

    /**
     * @return mixed
     */
    public function getIsOnetoone()
    {
        return $this->isOnetoone;
    }

    /**
     * @param mixed $isOnetoone
     */
    public function setIsOnetoone($isOnetoone): void
    {
        $this->isOnetoone = $isOnetoone;
    }

    /**
     * @return mixed
     */
    public function getRegieTabacId()
    {
        return $this->regieTabacId;
    }

    /**
     * @param mixed $regieTabacId
     */
    public function setRegieTabacId($regieTabacId): void
    {
        $this->regieTabacId = $regieTabacId;
    }

    /**
     * @return mixed
     */
    public function getRecetteprincipalId()
    {
        return $this->recetteprincipalId;
    }

    /**
     * @param mixed $recetteprincipalId
     */
    public function setRecetteprincipalId($recetteprincipalId): void
    {
        $this->recetteprincipalId = $recetteprincipalId;
    }

    /**
     * @return mixed
     */
    public function getRecettescecondaireId()
    {
        return $this->recettescecondaireId;
    }

    /**
     * @param mixed $recettescecondaireId
     */
    public function setRecettescecondaireId($recettescecondaireId): void
    {
        $this->recettescecondaireId = $recettescecondaireId;
    }

    /**
     * @return mixed
     */
    public function getCompagneId()
    {
        return $this->compagneId;
    }

    /**
     * @param mixed $compagneId
     */
    public function setCompagneId($compagneId): void
    {
        $this->compagneId = $compagneId;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $regieTabacId;

    /**
     * @ORM\Column(type="integer")
     */
    private $recetteprincipalId;

    /**
     * @ORM\Column(type="integer")
     */
    private $recettescecondaireId;


    /**
     * @ORM\Column(type="boolean")
     */
    private $isTlp;

    /**
     * @return mixed
     */
    public function getIsTlp()
    {
        return $this->isTlp;
    }

    /**
     * @param mixed $isTlp
     */
    public function setIsTlp($isTlp): void
    {
        $this->isTlp = $isTlp;
    }

    /**
     * @return mixed
     */
    public function getIsFsPotentiel()
    {
        return $this->isFsPotentiel;
    }

    /**
     * @param mixed $isFsPotentiel
     */
    public function setIsFsPotentiel($isFsPotentiel): void
    {
        $this->isFsPotentiel = $isFsPotentiel;
    }


    /**
     * @ORM\Column(type="boolean")
     */
    private $isFsPotentiel;

    /**
     * @ORM\Column(type="integer")
     */
    private $compagneId;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $commentPlv;

    /**
     * @return mixed
     */
    public function getCommentPlv()
    {
        return $this->commentPlv;
    }

    /**
     * @param mixed $commentPlv
     * @return NewInstallPdv
     */
    public function setCommentPlv($commentPlv)
    {
        $this->commentPlv = $commentPlv;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlv()
    {
        return $this->plv;
    }

    /**
     * @param mixed $plv
     * @return NewInstallPdv
     */
    public function setPlv($plv)
    {
        $this->plv = $plv;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
    }


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NewInstallPdvComments", mappedBy="newInstallPdv", cascade={"persist", "remove"})
     */
    private $newInstallComments;

    /**
     * @ORM\Column(type="array")
     */
    private $minStock = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $routings = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $plv = [];
    /**
     * @return mixed
     */
    public function getRoutings()
    {
        return $this->routings;
    }

    /**
     * @param mixed $routings
     */
    public function setRoutings($routings): void
    {
        $this->routings = $routings;
    }

    /**
     * @return Collection|NewInstallPdvComments[]
     */
    public function getNewInstallComments(): Collection
    {
        return $this->newInstallComments;
    }

    public function addNewInstallComment(NewInstallPdvComments $newInstallComment): self
    {
        if (!$this->newInstallComments->contains($newInstallComment)) {
            $this->newInstallComments[] = $newInstallComment;
            $newInstallComment->setNewInstallPdv($this);
        }

        return $this;
    }

    public function removeNewInstallComment(NewInstallPdvComments $newInstallComment): self
    {
        if ($this->newInstallComments->contains($newInstallComment)) {
            $this->newInstallComments->removeElement($newInstallComment);
            // set the owning side to null (unless already changed)
            if ($newInstallComment->getNewInstallPdv() === $this) {
                $newInstallComment->setNewInstallPdv(null);
            }
        }

        return $this;
    }

    public function getMinStock(): ?array
    {
        return $this->minStock;
    }

    public function setMinStock(array $minStock): self
    {
        $this->minStock = $minStock;

        return $this;
    }

}
