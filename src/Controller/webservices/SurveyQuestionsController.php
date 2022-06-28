<?php


namespace App\Controller\webservices;

use App\Entity\Merch;
use App\Entity\Survey;
use App\Entity\SurveyQuestions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

/**
 * @Route ("api", name="api_")
 * Class SurveyQuestionsController
 * @package App\Controller\webservices
 */
class SurveyQuestionsController extends MainController
{
    /**
     * @Rest\Get("/surveyquestions/showall", name="survey_questions_show_all")
     */
    public function index()
    {
        $surveyQuestions = $this->em->getRepository(SurveyQuestions::class)->findall();
        if (isset($surveyQuestions)) {
            return $this->successResponse($surveyQuestions);
        }
    }

    /**
     * @Rest\Get("/surveyquestions/{id}", name="survey_questions_show_by_id")
     * @return Response\
     */
    public function show(int $id)
    {
        $surveyQuestions = $this->em->getRepository(SurveyQuestions::class)->find($id);
        if (isset($surveyQuestions)) {
            return $this->successResponse($surveyQuestions);
        }
    }


    /**
     * @Rest\Post("/surveyquestions/create", name="survey_questions_create")
     * @return Response
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function create(Request $request)
    {
        // $em instanceof EntityManager
        $this->em->getConnection()->beginTransaction(); // suspend auto-commit
        try {
            $jsonData = json_decode($request->getContent(), true);
            $surveyTitle = $jsonData["title"];
            $idCycle = $jsonData["id_cycle"];
            $merchs = $jsonData["merchs"];
            $arrayData = array("title" => $surveyTitle, "idCycle" => $idCycle, "merchs" => $merchs);
            $idSurvey = ($this->saveSurvey($arrayData))->getContent();
            $surveyObject = $this->em->getRepository(Survey::class)->find($idSurvey);
            $listOfQuestions = $jsonData["list_questions"];
            foreach ($listOfQuestions as $question) {
                $surveyQuestions = new SurveyQuestions();
                $surveyQuestions->setQuestions($question["question"]);
                $surveyQuestions->setFormTypes($question["form_type"]);
                $surveyQuestions->setOptions($question["options"]);
                $surveyQuestions->setSurvey($surveyObject);
                $this->em->persist($surveyQuestions);
            }
            $this->em->getConnection()->commit();
            $this->em->flush();
            return $this->successResponse(["code" => 200, "message" => true]);


        } catch (Exception $e) {
            $this->em->getConnection()->rollBack();
            throw $e;
        }
    }

    /**
     * Function to save Data into Survey entity(id,title,cycleId,merchs(M2M relation))
     * @return the id of Survey
     */
    private function saveSurvey($data)
    {
        $result = $this->forward('App\Controller\webservices\SurveyController::create', [
            'data' => $data,
        ]);
        return $result;
    }

    /**
     * @Rest\Post("/survey/update/surveyandquestions", name="survey_questions_update")
     * @return Response
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function update(Request $request)
    {
        // $em instanceof EntityManager
        $this->em->getConnection()->beginTransaction(); // suspend auto-commit
        try {
            $jsonData = json_decode($request->getContent(), true);
            $surveyId = $jsonData["id"];
            $surveyTitle = $jsonData["title"];
            $idCycle = $jsonData["id_cycle"];
            $idMerchs = $jsonData["merchs"];
            $surveyObject = $this->em->getRepository(Survey::class)->find($surveyId);
            $surveyObject->setTitle($surveyTitle ?? $surveyObject->getTitle());
            $surveyObject->setCycle($idCycle ?? $surveyObject->getCycle());
            // delete all related merchs survey if we got empty array of merchs when update survey
            if (!empty($idMerchs)) {
                $this->removeOldMerchs($surveyObject);
                $this->addNewMerchs($idMerchs,$surveyObject);
                $this->em->flush();

            } else {
                $this->removeOldMerchs($surveyObject);
                $this->em->flush();
            }
            $listOfQuestions = $jsonData["list_questions"];
            foreach ($listOfQuestions as $question) {
                if (isset($question['id'])) {
                    // if id exist than update the survey question referenced by id
                    $surveyQuestions = $this->em->getRepository(SurveyQuestions::class)->find($question['id']);
                    if (isset($surveyQuestions)) {
                        $surveyQuestions->setQuestions($question["question"] ?? $surveyQuestions->getQuestions());
                        $surveyQuestions->setFormTypes($question["form_type"] ?? $surveyQuestions->getFormTypes());
                        $surveyQuestions->setOptions($question["options"] ?? $surveyQuestions->getOptions());
                        $surveyQuestions->setSurvey($surveyObject ?? $surveyQuestions->getSurvey());
                        $this->em->persist($surveyQuestions);
                    }
                } else {
                    // if there is no id sended so we create new survey question
                    $newSurveyQuestions = new SurveyQuestions();
                    $newSurveyQuestions->setQuestions($question["question"]);
                    $newSurveyQuestions->setFormTypes($question["form_type"]);
                    $newSurveyQuestions->setOptions($question["options"]);
                    $newSurveyQuestions->setSurvey($surveyObject);
                    $this->em->persist($newSurveyQuestions);
                }
            }
            $this->em->getConnection()->commit();
            $this->em->flush();
            return $this->successResponse(["code" => 200, "message" => true]);

        } catch (Exception $e) {
            $this->em->getConnection()->rollBack();
            throw $e;
        }
    }

    /**
     * @Rest\Delete("/surveyquestions/{id}/delete", name="survey_questions_delete")
     */
    public function delete(int $id)
    {
        $surveyQuestions = $this->em->getRepository(SurveyQuestions::class)->find($id);
        if (isset($surveyQuestions)) {
            $this->em->remove($surveyQuestions);
            $this->em->flush();
            return $this->successResponse(" SURVEY QUESTION DELETED");
        }
    }

    /************************************ Duplicate Survey+Questions *******************************************/
    /**
     * Function to Duplicate Survey(Sondage) and related Questions
     * @Rest\Post("/duplicatesurveyfrom/{id}", name="duplicate_survey_and_questions")
     */
    public function duplicate(int $id)
    {
        $surveyObject = $this->em->getRepository(Survey::class)->find($id);
        $newDuplicatedSurvey = new Survey();
        $newDuplicatedSurvey->setTitle($surveyObject->getTitle() . " Copy");
        $newDuplicatedSurvey->setCycle($surveyObject->getCycle());
        $newDuplicatedSurvey->setVisibility($surveyObject->getVisibility());
        $merchs = $surveyObject->getMerch();
        foreach ($merchs as $merch) {
            $newDuplicatedSurvey->addMerch($merch);
        }
        $this->em->persist($newDuplicatedSurvey);

        $surveyQuestions = $this->em->getRepository(SurveyQuestions::class)->findAllQuestionOfSurvey($id);
        foreach ($surveyQuestions as $question) {
            $newDuplicatedSurveyQuestion = new SurveyQuestions();
            $newDuplicatedSurveyQuestion->setQuestions($question->getQuestions());
            $newDuplicatedSurveyQuestion->setFormTypes($question->getFormTypes());
            $newDuplicatedSurveyQuestion->setOptions($question->getOptions());
            $newDuplicatedSurveyQuestion->setSurvey($newDuplicatedSurvey);
            $this->em->persist($newDuplicatedSurveyQuestion);
        }
        $this->em->flush();
        $result = $this->customShowSurvey($newDuplicatedSurvey->getId());
        /** @var TYPE_NAME $result */
        return $result;
    }


    /**
     * Function to return custom response of survey
     * @param $data
     * @return Response
     */
    public function customShowSurvey($data)
    {
        $result = $this->forward('App\Controller\webservices\SurveyController::show', [
            'id' => $data,
        ]);
        return $result;
    }

    private function removeOldMerchs($param)
    {
        $allMerchs = $param->getMerch();
        foreach ($allMerchs as $merch) {
            $param->removeMerch($merch);
            $this->em->persist($param);
            $this->em->flush();
        }

    }

    private function addNewMerchs($idMerchs, ?Survey $surveyObject)
    {
        foreach ($idMerchs as $idMerch) {
            $merchObject = $this->em->getRepository(Merch::class)->find($idMerch);
            $surveyObject->addMerch($merchObject);
            $this->em->persist($surveyObject);
            $this->em->flush();
        }
    }


}