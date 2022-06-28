<?php

namespace App\Entity;
use app\Entity\StokeContainer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 *
 *
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",nullable=true, unique=true)
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $recetteP;

    /**
     * @return mixed
     */
    public function getRecetteP()
    {
        return $this->recetteP;
    }

    /**
     * @param mixed $recetteP
     */
    public function setRecetteP($recetteP): void
    {
        $this->recetteP = $recetteP;
    }

    /**
     * @return mixed
     */
    public function getRecetteS()
    {
        return $this->recetteS;
    }

    /**
     * @param mixed $recetteS
     */
    public function setRecetteS($recetteS): void
    {
        $this->recetteS = $recetteS;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $recetteS;



    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="integer")
     */
    private $draft;

    /**
     * @return mixed
     */
    public function getDraft()
    {
        return $this->draft;
    }

    /**
     * @param mixed $draft
     */
    public function setDraft($draft): void
    {
        $this->draft = $draft;
    }


    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $longitude;

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
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $infoAccPdv;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $dateSignature;

    /**
     * @ORM\Column(type="string", length=255,nullable=true,nullable=true)
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
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $dateInstalation;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isTlp;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $vendeur;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $jourVisite;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isOneToOne;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isFsPotentiel;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $numLicence;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $nmbAffectation;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $merchId;

    /**
     * @return mixed
     */
    public function getMerchId()
    {
        return $this->merchId;
    }

    /**
     * @param mixed $merchId
     */
    public function setMerchId($merchId): void
    {
        $this->merchId = $merchId;
    }

    /**
     * @return mixed
     */
    public function getNmbAffectation()
    {
        return $this->nmbAffectation;
    }

    /**
     * @param mixed $nmbAffectation
     */
    public function setNmbAffectation($nmbAffectation): void
    {
        $this->nmbAffectation = $nmbAffectation;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InfoClient", mappedBy="client", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $infoClient;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PdvSuperficie", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $superficie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PdvEmplacements", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $emplacement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PdvEnvironnements", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $environnement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PdvTypesQuartier", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $typeDeQuartier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PdvVisibilite", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $visibiliter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PdvClasses", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $classe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PdvTypologies", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $typologie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PdvPresentoire", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $presentoire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quartier", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $quartier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MarketingRegieTabac", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $regieTabac;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MarketingCampagneEnCours", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $companieOncour;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MarketingRecette", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $recette;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Produit", inversedBy="clients",fetch="LAZY")
     * @ORM\JoinColumn(nullable=true)
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NbrEmployer", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $nbrEmplyer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sheetClient;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="sheetClient")
     * @ORM\JoinColumn(nullable=true)
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StokeSheet", mappedBy="client")
     * @ORM\JoinColumn(nullable=true)
     */
    private $stokesheet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeClient", inversedBy="clients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $decider;


    public function __construct()
    {
        $this->infoClient = new ArrayCollection();
        $this->produit = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->stokesheet = new ArrayCollection();
        $this->rapportPPOSMs = new ArrayCollection();
        $this->routings = new ArrayCollection();
        $this->file = new ArrayCollection();
        $this->posPhotos = new ArrayCollection();
        $this->commentPdv = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


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
    public function getInfoAccPdv()
    {
        return $this->infoAccPdv;
    }

    /**
     * @param mixed $infoAccPdv
     */
    public function setInfoAccPdv($infoAccPdv): void
    {
        $this->infoAccPdv = $infoAccPdv;
    }

    /**
     * @return mixed
     */
    public function getDateSignature()
    {
        return $this->dateSignature;
    }

    /**
     * @param mixed $dateSignature
     */
    public function setDateSignature($dateSignature): void
    {
        $this->dateSignature = $dateSignature;
    }

    /**
     * @return mixed
     */
    public function getDateInstalation()
    {
        return $this->dateInstalation;
    }

    /**
     * @param mixed $dateInstalation
     */
    public function setDateInstalation($dateInstalation): void
    {
        $this->dateInstalation = $dateInstalation;
    }

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
    public function getVendeur()
    {
        return $this->vendeur;
    }

    /**
     * @param mixed $vendeur
     */
    public function setVendeur($vendeur): void
    {
        $this->vendeur = $vendeur;
    }

    /**
     * @return mixed
     */
    public function getJourVisite()
    {
        return $this->jourVisite;
    }

    /**
     * @param mixed $jourVisite
     */
    public function setJourVisite($jourVisite): void
    {
        $this->jourVisite = $jourVisite;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getIsOneToOne()
    {
        return $this->isOneToOne;
    }

    /**
     * @param mixed $isOneToOne
     */
    public function setIsOneToOne($isOneToOne): void
    {
        $this->isOneToOne = $isOneToOne;
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
    public function getNumLicence()
    {
        return $this->numLicence;
    }

    /**
     * @param mixed $numLicence
     */
    public function setNumLicence($numLicence): void
    {
        $this->numLicence = $numLicence;
    }

    /**
     * @return Collection|InfoClient[]
     */
    public function getInfoClient(): Collection
    {
        return $this->infoClient;
    }

    public function addInfoClient(InfoClient $infoClient): self
    {
        if (!$this->infoClient->contains($infoClient)) {
            $this->infoClient[] = $infoClient;
            $infoClient->setClient($this);
        }

        return $this;
    }

    public function removeInfoClient(InfoClient $infoClient): self
    {
        if ($this->infoClient->contains($infoClient)) {
            $this->infoClient->removeElement($infoClient);
            // set the owning side to null (unless already changed)
            if ($infoClient->getClient() === $this) {
                $infoClient->setClient(null);
            }
        }

        return $this;
    }

    public function getSuperficie(): ?PdvSuperficie
    {
        return $this->superficie;
    }

    public function setSuperficie(?PdvSuperficie $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getEmplacement(): ?PdvEmplacements
    {
        return $this->emplacement;
    }

    public function setEmplacement(?PdvEmplacements $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getEnvironnement(): ?PdvEnvironnements
    {
        return $this->environnement;
    }

    public function setEnvironnement(?PdvEnvironnements $environnement): self
    {
        $this->environnement = $environnement;

        return $this;
    }

    public function getTypeDeQuartier(): ?PdvTypesQuartier
    {
        return $this->typeDeQuartier;
    }

    public function setTypeDeQuartier(?PdvTypesQuartier $typeDeQuartier): self
    {
        $this->typeDeQuartier = $typeDeQuartier;

        return $this;
    }

    public function getVisibiliter(): ?PdvVisibilite
    {
        return $this->visibiliter;
    }

    public function setVisibiliter(?PdvVisibilite $visibiliter): self
    {
        $this->visibiliter = $visibiliter;

        return $this;
    }

    public function getClasse(): ?PdvClasses
    {
        return $this->classe;
    }

    public function setClasse(?PdvClasses $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getTypologie(): ?PdvTypologies
    {
        return $this->typologie;
    }

    public function setTypologie(?PdvTypologies $typologie): self
    {
        $this->typologie = $typologie;

        return $this;
    }

    public function getPresentoire(): ?PdvPresentoire
    {
        return $this->presentoire;
    }

    public function setPresentoire(?PdvPresentoire $presentoire): self
    {
        $this->presentoire = $presentoire;

        return $this;
    }

    public function getQuartier(): ?Quartier
    {
        return $this->quartier;
    }

    public function setQuartier(?Quartier $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getRegieTabac(): ?MarketingRegieTabac
    {
        return $this->regieTabac;
    }

    public function setRegieTabac(?MarketingRegieTabac $regieTabac): self
    {
        $this->regieTabac = $regieTabac;

        return $this;
    }

    public function getCompanieOncour(): ?MarketingCampagneEnCours
    {
        return $this->companieOncour;
    }

    public function setCompanieOncour(?MarketingCampagneEnCours $companieOncour): self
    {
        $this->companieOncour = $companieOncour;

        return $this;
    }

    public function getRecette(): ?MarketingRecette
    {
        return $this->recette;
    }

    public function setRecette(?MarketingRecette $recette): self
    {
        $this->recette = $recette;

        return $this;
    }

    /*
        public function __toStringrecetteP(){
            return $this->recetteP;
        }

        public function __toStringrecetteS(){
            return $this->recetteS;
        }

        public function __toStringrecette(){
            return $this->recette;
        }*/
    /**
     * @return Collection|Produit[]
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produit->contains($produit)) {
            $this->produit->removeElement($produit);
        }

        return $this;
    }

    public function getNbrEmplyer(): ?NbrEmployer
    {
        return $this->nbrEmplyer;
    }

    public function setNbrEmplyer(?NbrEmployer $nbrEmplyer): self
    {
        $this->nbrEmplyer = $nbrEmplyer;

        return $this;
    }

    public function getSheetClient(): ?self
    {
        return $this->sheetClient;
    }

    public function setSheetClient(?self $sheetClient): self
    {
        $this->sheetClient = $sheetClient;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(self $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setSheetClient($this);
        }

        return $this;
    }

    public function removeClient(self $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getSheetClient() === $this) {
                $client->setSheetClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StokeSheet[]
     */
    public function getStokesheet(): Collection
    {
        return $this->stokesheet;
    }

    public function addStokesheet(StokeSheet $stokesheet): self
    {
        if (!$this->stokesheet->contains($stokesheet)) {
            $this->stokesheet[] = $stokesheet;
            $stokesheet->setClient($this);
        }

        return $this;
    }

    public function removeStokesheet(StokeSheet $stokesheet): self
    {
        if ($this->stokesheet->contains($stokesheet)) {
            $this->stokesheet->removeElement($stokesheet);
            // set the owning side to null (unless already changed)
            if ($stokesheet->getClient() === $this) {
                $stokesheet->setClient(null);
            }
        }

        return $this;
    }

    public function getDecider(): ?TypeClient
    {
        return $this->decider;
    }

    public function setDecider(?TypeClient $decider): self
    {
        $this->decider = $decider;

        return $this;
    }

    /**
     * @return Collection|RapportPPOSM[]
     */
    public function getRapportPPOSMs(): Collection
    {
        return $this->rapportPPOSMs;
    }

    public function addRapportPPOSM(RapportPPOSM $rapportPPOSM): self
    {
        if (!$this->rapportPPOSMs->contains($rapportPPOSM)) {
            $this->rapportPPOSMs[] = $rapportPPOSM;
            $rapportPPOSM->setClient($this);
        }

        return $this;
    }

    public function removeRapportPPOSM(RapportPPOSM $rapportPPOSM): self
    {
        if ($this->rapportPPOSMs->contains($rapportPPOSM)) {
            $this->rapportPPOSMs->removeElement($rapportPPOSM);
            // set the owning side to null (unless already changed)
            if ($rapportPPOSM->getClient() === $this) {
                $rapportPPOSM->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Routing", mappedBy="clients")
     *
     */
    private $routings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="client")
     *
     */
    private $file;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="client")
     */
    private $commentPdv;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\StokeContainer", cascade={"persist", "remove"})
     */
    private $stokeContainer;




    /**
     * @return Collection|Routing[]
     */
    public function getRoutings(): Collection
    {
        return $this->routings;
    }

    public function addRouting(Routing $routing): self
    {
        if (!$this->routings->contains($routing)) {
            $this->routings[] = $routing;
            $routing->addClient($this);
        }

        return $this;
    }

    public function removeRouting(Routing $routing): self
    {
        if ($this->routings->contains($routing)) {
            $this->routings->removeElement($routing);
            $routing->removeClient($this);
        }

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getFile(): Collection
    {
        return $this->file;
    }

    public function addFile(File $file): self
    {
        if (!$this->file->contains($file)) {
            $this->file[] = $file;
            $file->setClient($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->file->contains($file)) {
            $this->file->removeElement($file);
            // set the owning side to null (unless already changed)
            if ($file->getClient() === $this) {
                $file->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentPdv(): Collection
    {
        return $this->commentPdv;
    }

    public function addCommentPdv(Commentaire $commentPdv): self
    {
        if (!$this->commentPdv->contains($commentPdv)) {
            $this->commentPdv[] = $commentPdv;
            $commentPdv->setClient($this);
        }

        return $this;
    }

    public function removeCommentPdv(Commentaire $commentPdv): self
    {
        if ($this->commentPdv->contains($commentPdv)) {
            $this->commentPdv->removeElement($commentPdv);
            // set the owning side to null (unless already changed)
            if ($commentPdv->getClient() === $this) {
                $commentPdv->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stoke[]
     */
    public function getStokes(): Collection
    {
        return $this->stokes;
    }

    public function addStoke(Stoke $stoke): self
    {
        if (!$this->stokes->contains($stoke)) {
            $this->stokes[] = $stoke;
            $stoke->addClient($this);
        }

        return $this;
    }

    public function removeStoke(Stoke $stoke): self
    {
        if ($this->stokes->contains($stoke)) {
            $this->stokes->removeElement($stoke);
            $stoke->removeClient($this);
        }

        return $this;
    }

    public function getStokeContainer(): ?StokeContainer
    {
        return $this->stokeContainer;
    }

    public function setStokeContainer(?StokeContainer $stokeContainer): self
    {
        $this->stokeContainer = $stokeContainer;

        return $this;
    }



}
