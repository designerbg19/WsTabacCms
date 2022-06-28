<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TypeProduit;
use App\Entity\File;



/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isVisible;

    /**
     * @return mixed
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * @param mixed $isVisible
     */
    public function setIsVisible($isVisible): void
    {
        $this->isVisible = $isVisible;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Many produits have one TypeProduits. This is the owning side.
     * @ORM\ManyToOne(targetEntity="TypeProduit", inversedBy="produits")
     *
     */
    private $typeproduit;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\File", cascade={"persist", "remove"})
     */
    private $file;

    public function __construct()
    {
        $this->stokeSheet = new ArrayCollection();
        $this->tlpStokeCourants = new ArrayCollection();
       // $this->stokes = new ArrayCollection();
    }

       /**
     * @return mixed
     */
    public function getTypeproduit()
    {
        return $this->typeproduit;
    }

    /**
     * @param mixed $typeproduit
     */
    public function setTypeproduit($typeproduit): void
    {
        $this->typeproduit = $typeproduit;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return Collection|StokeSheet[]
     */
    public function getStokeSheet(): Collection
    {
        return $this->stokeSheet;
    }

    public function addStokeSheet(StokeSheet $stokeSheet): self
    {
        if (!$this->stokeSheet->contains($stokeSheet)) {
            $this->stokeSheet[] = $stokeSheet;
            $stokeSheet->setProduit($this);
        }

        return $this;
    }

    public function removeStokeSheet(StokeSheet $stokeSheet): self
    {
        if ($this->stokeSheet->contains($stokeSheet)) {
            $this->stokeSheet->removeElement($stokeSheet);
            // set the owning side to null (unless already changed)
            if ($stokeSheet->getProduit() === $this) {
                $stokeSheet->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TlpStokeCourant[]
     */
    public function getTlpStokeCourants(): Collection
    {
        return $this->tlpStokeCourants;
    }

    public function addTlpStokeCourant(TlpStokeCourant $tlpStokeCourant): self
    {
        if (!$this->tlpStokeCourants->contains($tlpStokeCourant)) {
            $this->tlpStokeCourants[] = $tlpStokeCourant;
            $tlpStokeCourant->addProduit($this);
        }

        return $this;
    }

    public function removeTlpStokeCourant(TlpStokeCourant $tlpStokeCourant): self
    {
        if ($this->tlpStokeCourants->contains($tlpStokeCourant)) {
            $this->tlpStokeCourants->removeElement($tlpStokeCourant);
            $tlpStokeCourant->removeProduit($this);
        }

        return $this;
    }

   }
