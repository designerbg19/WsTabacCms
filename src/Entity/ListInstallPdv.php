<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListInstallPdvRepository")
 */
class ListInstallPdv
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $newInstallId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titulaireNom;

    /**
     * @ORM\Column(type="integer")
     */
    private $gouvernoratId;

    /**
     * @ORM\Column(type="integer")
     */
    private $quartierId;

    /**
     * @ORM\Column(type="integer")
     */
    private $statusNewInstall;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $installDay;

    /**
     * @return mixed
     */
    public function getInstallDay()
    {
        return $this->installDay;
    }

    /**
     * @param mixed $installDay
     */
    public function setInstallDay($installDay): void
    {
        $this->installDay = $installDay;
    }

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

    /**
     * @ORM\Column(type="integer")
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNewInstallId(): ?int
    {
        return $this->newInstallId;
    }

    public function setNewInstallId(int $newInstallId): self
    {
        $this->newInstallId = $newInstallId;

        return $this;
    }

    public function getTitulaireNom(): ?string
    {
        return $this->titulaireNom;
    }

    public function setTitulaireNom(string $titulaireNom): self
    {
        $this->titulaireNom = $titulaireNom;

        return $this;
    }

    public function getGouvernoratId(): ?int
    {
        return $this->gouvernoratId;
    }

    public function setGouvernoratId(int $gouvernoratId): self
    {
        $this->gouvernoratId = $gouvernoratId;

        return $this;
    }

    public function getQuartierId(): ?int
    {
        return $this->quartierId;
    }

    public function setQuartierId(int $quartierId): self
    {
        $this->quartierId = $quartierId;

        return $this;
    }


}
