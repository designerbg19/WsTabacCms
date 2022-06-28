<?php


namespace App\Controller\webservices;

use App\Entity\Merch;
use App\Entity\Survey;
use App\Entity\SurveyQuestions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route ;

/**
 * @Route ("api", name="api_")
 * Class SurveyController
 * @package App\Controller\webservices
 */
class SurveyController extends MainController
{
    /**
     * @Rest\Get("/survey/showall", name="survey_show_all")
     */
    public function index()
    {
        $survey = $this->em->getRepository(Survey::class)->customFindAll();
        if(isset($survey)) {
            return $this->successResponse($survey);
        }
    }

    /**
     * @Rest\Get("/surveypagination/showall", name="survey_pagination_show_all")
     */
    public function showSurveyWithPagination(Request $request)
    {
        $query = $this->em->getRepository(Survey::class)->customFindAllWithPagination();
        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            self::NUMBER_ITEM_PER_PAGE /*limit per page*/
        );
        if(isset($pagination)) {
            return $this->successResponse($pagination);
        }
    }
    /**
     * @Rest\Get("/survey/{id}", name="survey_show_by_id")
     * @return Response\
     */
    public function show(int $id)
    {
        $survey = $this->em->getRepository(Survey::class)->customFindSurvey($id);
        $surveyMerchs = $this->em->getRepository(Survey::class)->customFindSurveyMerchs($id);
        $surveyQuestions = $this->em->getRepository(SurveyQuestions::class)->findCustomQuestionOfSurvey($id);
        if(isset($survey)) {
            return $this->successResponse(array("survey"=>$survey,"questions"=>$surveyQuestions,"merchs"=>$surveyMerchs));
        }
    }



    /**
     * @Rest\Post("/survey/create", name="survey_create")
     * @return Response id of Survey (sondage)
     */
    public function create($data)
    {
        $surveyTitle = $data["title"];
        $idCycle = $data["idCycle"];
        $idMerchs = $data["merchs"];
        $survey = new  Survey();
        $survey->setTitle($surveyTitle);
        $survey->setCycle($idCycle);
        $survey->setVisibility(0);
        if(!empty($idMerchs)){
            foreach ($idMerchs as $idMerch){
                $merchObject = $this->em->getRepository(Merch::class)->find($idMerch);
                $survey->addMerch($merchObject);
            }
        }
        $this->em->persist($survey);
        $this->em->flush();
        return $survey->getId();
    }


    /**
     * Function to update visibility of survey
     * @Rest\Post("/surveyvisibility/{id}", name="servey_visibility")
     * @return Response
     */
    public function surveyVisibility(int $id)
    {
        $survey =$this->em->getRepository(Survey::class)->find($id);
        if($survey->getVisibility() == 0){
            $survey->setVisibility(1);
        }else{
            $survey->setVisibility(0);
        }
        $this->em->persist($survey);
        $this->em->flush();
        return $this->successResponse("");
    }

    /**
     * @Rest\Delete("/survey/{id}/delete", name="servey_delete")
     */
    public function delete( int $id)
    {
        $survey = $this->em->getRepository(Survey::class)->find($id);
        if(isset($survey)){
            $this->em->remove($survey);
            $this->em->flush();
            return $this->successResponse(["code"=>200,"message"=>"SURVEY DELETED"]);
        }
    }



/************************************ Survey(Sondage) by cycle / merch  *******************************************/

    /**
     * Function to get Survey (Sondage) by Cycle (for App iPad Part)
     * @Rest\Get("/surveybycycle", name="survey_by_cycle")
     * @return Response
     * @throws \Exception
     */
    public function showSurveyByCycle()
    {
        $numberOfCycle = $this->getCurrentCycleNumberByDateNow();
        $cycleId =$numberOfCycle[0];
        $numCycle =$numberOfCycle[1];
        $surveyByCycle = $this->em->getRepository(Survey::class)->findSurveyByCycle($cycleId);
        if(isset($surveyByCycle)){
            $data [] = array("num_cycle"=>$numCycle,
                "survey_by_cycle"=> $surveyByCycle
            );
            return $this->successResponse($surveyByCycle);
        }
    }

    /**
     * Function to get all survey(Sondage) by Merch (for App iPad Part)
     * @Rest\Get("/surveybymerchbycycle/{id}", name="survey_by_merch")
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function showSurveyByMerch(int $id)
    {
        $merchObject = $this->em->getRepository(Merch::class)->find($id);
         //if Merch id exist than continue
        if(isset($merchObject)) {
            $numberOfCycle = $this->getCurrentCycleNumberByDateNow();
            $cycleId = $numberOfCycle[0];
            $numCycle = $numberOfCycle[1];
            $surveyByMerchByCycle = $this->em->getRepository(Survey::class)->findSurveyByMerch($id,$cycleId);
            $surveyByCycle = $this->em->getRepository(Survey::class)->findSurveyByCycle($cycleId);
            if ($surveyByMerchByCycle) {
                $data [] = array(
                    //"numero_of_cycle" => $numCycle,
                    "survey_by_merch" => $surveyByMerchByCycle,
                    "survey_by_cycle" => $surveyByCycle
                );
                return $this->successResponse($data);
            } else {
                $data [] = array(
                   // "numero_of_cycle" => $numCycle,
                    "survey_by_merch" => $surveyByMerchByCycle,
                    "survey_by_cycle" => $surveyByCycle
                );
                return $this->successResponse($data);
            }
        }

    }


}