<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PersoRepository")
 * @Vich\Uploadable
 */
class Perso
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photos", mappedBy="perso")
     */
    private $image;

    public function __construct()
    {
        $this->image = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Photos[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Photos $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setPerso($this);
        }

        return $this;
    }

    public function removeImage(Photos $image): self
    {
        if ($this->image->contains($image)) {
            $this->image->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getPerso() === $this) {
                $image->setPerso(null);
            }
        }

        return $this;
    }



}
