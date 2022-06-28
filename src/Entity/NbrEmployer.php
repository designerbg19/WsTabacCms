<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NbrEmployerRepository")
 */
class NbrEmployer
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
    private $nbremployer;



    /**
     * @return mixed
     */
    public function getNbremployer()
    {
        return $this->nbremployer;
    }

    /**
     * @param mixed $nbremployer
     */
    public function setNbremployer($nbremployer): void
    {
        $this->nbremployer = $nbremployer;
    }



    public function __construct()
    {
        $this->infoClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



}
