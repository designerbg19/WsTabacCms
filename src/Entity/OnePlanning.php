<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OnePlanningRepository")
 */
class OnePlanning
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;



    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $a;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $am;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Merch", inversedBy="onePlannings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Merch;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cycle")
     * @ORM\JoinColumn(nullable=false, name="cycle_id", referencedColumnName="id")
     */
    private $cycle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $classment;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getA(): ?int
    {
        return $this->a;
    }

    public function setA(?int $a): self
    {
        $this->a = $a;

        return $this;
    }

    public function getAm(): ?int
    {
        return $this->am;
    }

    public function setAm(?int $am): self
    {
        $this->am = $am;

        return $this;
    }

    public function getMerch(): ?Merch
    {
        return $this->Merch;
    }

    public function setMerch(?Merch $Merch): self
    {
        $this->Merch = $Merch;

        return $this;
    }

    public function getCycle(): ?Cycle
    {
        return $this->cycle;
    }

    public function setCycle(?Cycle $cycle): self
    {
        $this->cycle = $cycle;

        return $this;
    }

    public function getClassment(): ?string
    {
        return $this->classment;
    }

    public function setClassment(string $classment): self
    {
        $this->classment = $classment;

        return $this;
    }

}
