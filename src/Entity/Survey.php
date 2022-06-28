<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SurveyRepository")
 */
class Survey
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cycle;

    /**
     * @return mixed
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * @param mixed $cycle
     * @return Survey
     */
    public function setCycle($cycle)
    {
        $this->cycle = $cycle;
        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SurveyQuestions", mappedBy="survey", cascade={"persist", "remove"})
     */
    private $surveyQuestions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Merch" )
     */
    private $merch;

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

    public function __construct()
    {
        $this->surveyQuestions = new ArrayCollection();
        $this->merch = new ArrayCollection();

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @return Survey
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return Collection|SurveyQuestions[]
     */
    public function getSurveyQuestions(): Collection
    {
        return $this->surveyQuestions;
    }

    public function addSurveyQuestion(SurveyQuestions $surveyQuestion): self
    {
        if (!$this->surveyQuestions->contains($surveyQuestion)) {
            $this->surveyQuestions[] = $surveyQuestion;
            $surveyQuestion->setSurvey($this);
        }

        return $this;
    }

    public function removeSurveyQuestion(SurveyQuestions $surveyQuestion): self
    {
        if ($this->surveyQuestions->contains($surveyQuestion)) {
            $this->surveyQuestions->removeElement($surveyQuestion);
            // set the owning side to null (unless already changed)
            if ($surveyQuestion->getSurvey() === $this) {
                $surveyQuestion->setSurvey(null);
            }
        }

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
