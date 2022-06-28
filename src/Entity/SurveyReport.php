<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SurveyReportRepository")
 */
class SurveyReport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $responses = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $merchId;

    /**
     * @ORM\Column(type="integer")
     */
    private $surveyId;

    /**
     * @ORM\Column(type="integer")
     */
    private $clientId;

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     * @return SurveyReport
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurveyId()
    {
        return $this->surveyId;
    }

    /**
     * @param mixed $survey
     * @return SurveyReport
     */
    public function setSurveyId($surveyId)
    {
        $this->surveyId = $surveyId;
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponses(): ?array
    {
        return $this->responses;
    }

    public function setResponses(array $responses): self
    {
        $this->responses = $responses;

        return $this;
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


}
