<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

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
     * @return Survey
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Notification
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="integer")
     */
    private $cycleId;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Merch", inversedBy="notification")
     */
    private $merch;

    public function __construct()
    {
        $this->merch = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCycleId(): ?int
    {
        return $this->cycleId;
    }

    public function setCycleId(int $cycleId): self
    {
        $this->cycleId = $cycleId;

        return $this;
    }

    /**
     * @return Collection|Merch[]
     */
    public function getMerch(): Collection
    {
        return $this->merch;
    }

    public function addMerch(Merch $merch): self
    {
        if (!$this->merch->contains($merch)) {
            $this->merch[] = $merch;
        }

        return $this;
    }

    public function removeMerch(Merch $merch): self
    {
        if ($this->merch->contains($merch)) {
            $this->merch->removeElement($merch);
        }

        return $this;
    }

}
