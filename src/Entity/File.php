<?php

namespace App\Entity;

use App\Service\FileUploader;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;


/**
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 */
class File
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
    private $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    public  function __construct()
    {
        $this->dateCreation = new \DateTime('NOW');
//        $this->setLabel($label);
//        $this->setPath($path);
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $classment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClientMiniReport", inversedBy="imagesClosedReport" , fetch="LAZY")
     */
    private $clientMiniReport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="posPhotos")
     */
    private $client;


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

    /**
     * @return mixed
     */
    public function getClassment()
    {
        return $this->classment;
    }

    /**
     * @param mixed $classment
     */
    public function setClassment($classment): void
    {
        $this->classment = $classment;
    }


    public function getClientMiniReport(): ?ClientMiniReport
    {
        return $this->clientMiniReport;
    }

    public function setClientMiniReport(?ClientMiniReport $clientMiniReport): self
    {
        $this->clientMiniReport = $clientMiniReport;

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


}
