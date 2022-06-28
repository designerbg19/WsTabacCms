<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoutingRepository")
 */
class Routing
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
    private $classe;

    /**
     * @ORM\Column(type="integer")
     */
    private $codeRouting;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $information;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrsPdv;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone", inversedBy="routings")
     * @ORM\JoinColumn(nullable=true)
     */
    private $zone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Client", inversedBy="routings")
     * @ORM\JoinColumn(nullable=true)
     */
    private $clients;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $merch;

    /**
     * @return mixed
     */
    public function getMerch()
    {
        return $this->merch;
    }

    /**
     * @param mixed $merch
     * @return Routing
     */
    public function setMerch($merch)
    {
        $this->merch = $merch;
        return $this;
    }

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(string $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getCodeRouting(): ?int
    {
        return $this->codeRouting;
    }

    public function setCodeRouting(int $codeRouting): self
    {
        $this->codeRouting = $codeRouting;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(string $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getNbrsPdv(): ?int
    {
        return $this->nbrsPdv;
    }

    public function setNbrsPdv(int $nbrsPdv): self
    {
        $this->nbrsPdv = $nbrsPdv;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
        }

        return $this;
    }


    
}
