<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\InfoClientRepository")
 */
class InfoClient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="infoClient")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SituationFamilialle", inversedBy="infoClients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $situationFamil;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Age", inversedBy="infoClients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $AgeClient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NbrEnfant", inversedBy="infoClients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $nbrEnfant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeClient", inversedBy="infoClients")
     */
    private $typeClientNew;

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getTypeClientNew(): ?TypeClient
    {
        return $this->typeClientNew;
    }

    public function setTypeClientNew(?TypeClient $typeClientNew): self
    {
        $this->typeClientNew = $typeClientNew;

        return $this;
    }

    public function getSituationFamil(): ?SituationFamilialle
    {
        return $this->situationFamil;
    }

    public function setSituationFamil(?SituationFamilialle $situationFamil): self
    {
        $this->situationFamil = $situationFamil;

        return $this;
    }

    public function getAgeClient(): ?Age
    {
        return $this->AgeClient;
    }

    public function setAgeClient(?Age $AgeClient): self
    {
        $this->AgeClient = $AgeClient;

        return $this;
    }

    public function getNbrEnfant(): ?NbrEnfant
    {
        return $this->nbrEnfant;
    }

    public function setNbrEnfant(?NbrEnfant $nbrEnfant): self
    {
        $this->nbrEnfant = $nbrEnfant;

        return $this;
    }

}
