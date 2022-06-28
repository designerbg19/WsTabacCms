<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientMiniReportRepository")
 */
class ClientMiniReport
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
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $merchId;


    /**
     * @ORM\Column(type="integer")
     */
    private $clientId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $closedReasonId;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $closedReasonAutre;

    /**
     * @ORM\Column(type="integer")
     */
    private $numCycle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="clientMiniReport", cascade={"persist", "remove"})
     */
    private $imagesClosedReport;

    public function __construct()
    {
        $this->imagesClosedReport = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getClosedReasonId()
    {
        return $this->closedReasonId;
    }

    /**
     * @param mixed $closedReasonId
     */
    public function setClosedReasonId($closedReasonId): void
    {
        $this->closedReasonId = $closedReasonId;
    }

    /**
     * @return mixed
     */
    public function getClosedReasonAutre()
    {
        return $this->closedReasonAutre;
    }

    /**
     * @param mixed $closedReasonAutre
     */
    public function setClosedReasonAutre($closedReasonAutre): void
    {
        $this->closedReasonAutre = $closedReasonAutre;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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


    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    public function setClientId(int $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getNumCycle(): ?int
    {
        return $this->numCycle;
    }

    public function setNumCycle(int $numCycle): self
    {
        $this->numCycle = $numCycle;

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getImagesClosedReport(): Collection
    {
        return $this->imagesClosedReport;
    }

    public function addImagesClosedReport(File $imagesClosedReport): self
    {
        if (!$this->imagesClosedReport->contains($imagesClosedReport)) {
            $this->imagesClosedReport[] = $imagesClosedReport;
            $imagesClosedReport->setClientMiniReport($this);
        }

        return $this;
    }

    public function removeImagesClosedReport(File $imagesClosedReport): self
    {
        if ($this->imagesClosedReport->contains($imagesClosedReport)) {
            $this->imagesClosedReport->removeElement($imagesClosedReport);
            // set the owning side to null (unless already changed)
            if ($imagesClosedReport->getClientMiniReport() === $this) {
                $imagesClosedReport->setClientMiniReport(null);
            }
        }

        return $this;
    }
}
