<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientStateByCycleByDayRepository")
 */
class ClientStateByCycleByDay
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $clientId;

    /**
     * @ORM\Column(type="integer")
     */
    private $etatId;

    /**
     * @ORM\Column(type="integer")
     */
    private $OnePlanningId;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEtatId(): ?int
    {
        return $this->etatId;
    }

    public function setEtatId(int $etatId): self
    {
        $this->etatId = $etatId;

        return $this;
    }

    public function getOnePlanningId(): ?int
    {
        return $this->OnePlanningId;
    }

    public function setOnePlanningId(int $OnePlanningId): self
    {
        $this->OnePlanningId = $OnePlanningId;

        return $this;
    }
}
