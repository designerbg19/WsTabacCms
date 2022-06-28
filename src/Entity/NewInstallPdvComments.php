<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewInstallPdvCommentsRepository")
 */
class NewInstallPdvComments
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
    private $comment;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $merchStatusComment;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $modifiedImage;

    /**
     * @return mixed
     */
    public function getModifiedImage()
    {
        return $this->modifiedImage;
    }

    /**
     * @param mixed $modifiedImage
     */
    public function setModifiedImage($modifiedImage): void
    {
        $this->modifiedImage = $modifiedImage;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NewInstallPdv", inversedBy="newInstallComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $newInstallPdv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getMerchStatusComment(): ?int
    {
        return $this->merchStatusComment;
    }

    public function setMerchStatusComment(int $merchStatusComment): self
    {
        $this->merchStatusComment = $merchStatusComment;

        return $this;
    }

    public function getNewInstallPdv(): ?NewInstallPdv
    {
        return $this->newInstallPdv;
    }

    public function setNewInstallPdv(?NewInstallPdv $newInstallPdv): self
    {
        $this->newInstallPdv = $newInstallPdv;

        return $this;
    }
}
