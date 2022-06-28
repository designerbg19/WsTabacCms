<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TlpRepository")
 */
class Tlp
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $planogramme;

    /**
     * @ORM\Column(type="boolean")
     */
    private $eclairage;

    /**
     * @ORM\Column(type="integer")
     */
    private $score = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $bonus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlanogramme(): ?bool
    {
        return $this->planogramme;
    }

    public function setPlanogramme(bool $planogramme): self
    {
        $this->planogramme = $planogramme;

        return $this;
    }

    public function getEclairage(): ?bool
    {
        return $this->eclairage;
    }

    public function setEclairage(bool $eclairage): self
    {
        $this->eclairage = $eclairage;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getBonus(): ?int
    {
        return $this->bonus;
    }

    public function setBonus(int $bonus): self
    {
        $this->bonus = $bonus;

        return $this;
    }
}
