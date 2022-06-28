<?php


namespace App\Controller\webservices;

use App\Entity\Survey;
use App\Entity\SurveyQuestions;
use App\Entity\SurveyReport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route ;

/**
 * @Route ("api", name="api_")
 * Class SurveyReportController
 * @package App\Controller\webservices
 */
class SurveyReportController extends MainController
{
    /**
     * @Rest\Get("/surveyreports/showall", name="survey_reports_show_all")
     */
    public function index()
    {
        $surveyReport = $this->em->getRepository(SurveyReport::class)->findall();
        if (isset($surveyReport)) {
            return $this->successResponse($surveyReport);
        }
    }

    /**
     * @Rest\Get("/surveyreports/{id}", name="survey_reports_show_by_id")
     * @return Response
     */
    public function show(int $id)
    {
        $surveyReport = $this->em->getRepository(SurveyReport::class)->find($id);
        if (isset($surveyReport)) {
            return $this->successResponse($surveyReport);
        }
    }

    /**
     * @Rest\Post("/surveyreports/create", name="survey_reports_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $jsonData = json_decode($request->getContent(),true);
        $data =$jsonData[0];
        $surveyReport = new  SurveyReport();
        $surveyReport->setSurveyId($data["id_survey"]);
        $surveyReport->setMerchId($data["id_merch"]);
        $surveyReport->setClientId($data["id_client"]);
        $surveyReport->setResponses($data["report"]);
        $this->em->persist($surveyReport);
        $this->em->flush();
        return $this->successResponse(["code"=>200,"message"=>"Survey Report Created"]);
    }

    /********** Custom show ********************/

    /**
     * @Rest\Get("/surveyresponses/{id}", name="custom_survey_reports_show_all")
     */
    public function customShowSurveyReport($id)
    {
        $surveyReport = $this->em->getRepository(SurveyReport::class)->findAllSurveyReport($id);
        foreach ($surveyReport as $rep){
            $idResponse =$rep->getId();
            $idMerch = $rep->getMerchId();
            $arrayOfResponses =$rep->getResponses();
            //print_r($arrayOfResponses);die();
            foreach ($arrayOfResponses as $response){
                $idQuestion = $response["id"];
                $question = $this->em->getRepository(SurveyQuestions::class)->find($idQuestion);
                //$questionOptions = $question->getOptions();
                $indiceResponses = $response["responses"];
                //$merchResponseValue =array_intersect_key($questionOptions,$indiceResponses);
                $dataRespo[] = array(
                  "id_question"=> $idQuestion,
                  "question"=>$question->getQuestions(),
                  "responses"=>  $indiceResponses
                );
            }
            $data[] =array(
                //"id_survey"=>$idResponse,
                "id_merch" =>$idMerch,
                "list_responses" =>$dataRespo
            );
            $dataRespo =null;
        }
            if(!empty($data)){
                return $this->successResponse($data);
            }else{
                return $this->successResponse(["code"=>204,"message"=>"Survey No Content"]);
            }
    }

}
