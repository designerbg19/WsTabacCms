<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SurveyQuestionsRepository")
 */
class SurveyQuestions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $questions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $formTypes;

    /**
     * @ORM\Column(type="array")
     */
    private $options = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Survey", inversedBy="surveyQuestions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $survey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestions(): ?string
    {
        return $this->questions;
    }

    public function setQuestions(string $questions): self
    {
        $this->questions = $questions;

        return $this;
    }

    public function getFormTypes(): ?string
    {
        return $this->formTypes;
    }

    public function setFormTypes(string $formTypes): self
    {
        $this->formTypes = $formTypes;

        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }
}
