<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GlobalPlanningRepository")
 */
class GlobalPlanning
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day1;

    /**
     * @return mixed
     */
    public function getDay1()
    {
        return $this->day1;
    }

    /**
     * @param mixed $day1
     */
    public function setDay1($day1): void
    {
        $this->day1 = $day1;
    }

    /**
     * @return mixed
     */
    public function getDay2()
    {
        return $this->day2;
    }

    /**
     * @param mixed $day2
     */
    public function setDay2($day2): void
    {
        $this->day2 = $day2;
    }

    /**
     * @return mixed
     */
    public function getDay3()
    {
        return $this->day3;
    }

    /**
     * @param mixed $day3
     */
    public function setDay3($day3): void
    {
        $this->day3 = $day3;
    }

    /**
     * @return mixed
     */
    public function getDay4()
    {
        return $this->day4;
    }

    /**
     * @param mixed $day4
     */
    public function setDay4($day4): void
    {
        $this->day4 = $day4;
    }

    /**
     * @return mixed
     */
    public function getDay5()
    {
        return $this->day5;
    }

    /**
     * @param mixed $day5
     */
    public function setDay5($day5): void
    {
        $this->day5 = $day5;
    }

    /**
     * @return mixed
     */
    public function getDay6()
    {
        return $this->day6;
    }

    /**
     * @param mixed $day6
     */
    public function setDay6($day6): void
    {
        $this->day6 = $day6;
    }

    /**
     * @return mixed
     */
    public function getDay7()
    {
        return $this->day7;
    }

    /**
     * @param mixed $day7
     */
    public function setDay7($day7): void
    {
        $this->day7 = $day7;
    }

    /**
     * @return mixed
     */
    public function getDay8()
    {
        return $this->day8;
    }

    /**
     * @param mixed $day8
     */
    public function setDay8($day8): void
    {
        $this->day8 = $day8;
    }

    /**
     * @return mixed
     */
    public function getDay9()
    {
        return $this->day9;
    }

    /**
     * @param mixed $day9
     */
    public function setDay9($day9): void
    {
        $this->day9 = $day9;
    }

    /**
     * @return mixed
     */
    public function getDay10()
    {
        return $this->day10;
    }

    /**
     * @param mixed $day10
     */
    public function setDay10($day10): void
    {
        $this->day10 = $day10;
    }

    /**
     * @return mixed
     */
    public function getDay11()
    {
        return $this->day11;
    }

    /**
     * @param mixed $day11
     */
    public function setDay11($day11): void
    {
        $this->day11 = $day11;
    }

    /**
     * @return mixed
     */
    public function getDay12()
    {
        return $this->day12;
    }

    /**
     * @param mixed $day12
     */
    public function setDay12($day12): void
    {
        $this->day12 = $day12;
    }

    /**
     * @return mixed
     */
    public function getDay13()
    {
        return $this->day13;
    }

    /**
     * @param mixed $day13
     */
    public function setDay13($day13): void
    {
        $this->day13 = $day13;
    }

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day3;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day4;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day5;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day6;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day7;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day8;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day9;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day10;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day11;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day12;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day13;

    /**
     * @ORM\Column(type="integer")
     */
    private $merchId;

    /**
     * @ORM\Column(type="integer")
     */
    private $numCycle;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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

    public function getNumCycle(): ?int
    {
        return $this->numCycle;
    }

    public function setNumCycle(int $numCycle): self
    {
        $this->numCycle = $numCycle;

        return $this;
    }

}
