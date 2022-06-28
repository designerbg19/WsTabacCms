<?php


namespace App\Controller\webservices;


use App\Entity\Client;
use App\Entity\ClientMiniReport;
use App\Entity\ClientStateByCycleByDay;
use App\Entity\File;
use App\Entity\Merch;
use App\Entity\PdvRaison;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route ("api", name="api_")
 *
 */
class ClientMiniReportController extends MainController
{
    /**
     * @Rest\Get("/clientsminireport/showall", name="client_mini_report_show_all")
     */
    public function index(Request $request)
    {
        $clientMiniReport = $this->em->getRepository(ClientMiniReport::class)->findAll();
        if (isset($clientMiniReport)) {
            return $this->successResponse($clientMiniReport);
        }
    }

    /**
     * @Rest\Get("/customminireportclient/showall", name="custom_client_mini_report_show_all")
     */
    public function customMiniReport(Request $request)
    {
        $clientMiniReport = $this->em->getRepository(ClientMiniReport::class)->findAll();
        foreach ($clientMiniReport as $report){
            $idMiniReport = $report->getId();
            $date = $report->getDate();
            $idClient = $report->getclientId();
            $idMerch = $report->getMerchId();
            $status = $report->getStatus();
            $otherReasonclosed = $report->getclosedReasonAutre();
            $idReasonclosed = $report->getclosedReasonId();
            $merchObject = $this->em->getRepository(Merch::class)->find($idMerch);
            $merchCodeAndName =$merchObject->getCode().' - '.$merchObject->getFirstName().' '.$merchObject->getLastName();
            $clientObject = $this->em->getRepository(Client::class)->find($idClient);
            $infoClientObject = $this->em->getRepository(Client::class)->findInfoClient($idClient);
            $infoClient= $infoClientObject[0]["nom"];
            $codeClientAndName =$clientObject->getCodeClient().' - '.$infoClient;
            if(isset($idReasonclosed)){
            $closedReasonObject = $this->em->getRepository(PdvRaison::class)->find($idReasonclosed);
               if(isset($closedReasonObject)){
                   $closedReason = $closedReasonObject->getLabel();
               }else{ $closedReason = null;}
            }else{
                $closedReason = null;
            }
            $images =$report->getImagesClosedReport();
            $data[]=array(
                "id"=>$idMiniReport,
                "date"=>$date,
                "merch"=>$merchCodeAndName,
                "quartier"=>$clientObject->getQuartier(),
                "point_de_vente"=>$codeClientAndName,
                "status"=>$status,
                "reason"=>$closedReason,
                "other"=>$otherReasonclosed,
                "images_closed_report"=>$images
            );
        }
        if(!empty($data)){
            return $this->successResponse($data);
        }else{ return $this->successResponse(["code"=>204,"message"=>"No Content"]);}


    }

    /**
     * @Rest\Get("/clientsminireport/showallpagination", name="client_mini_report_show_all_with_paginator")
     */
    public function findClientsMiniReportWithPagination(Request $request)
    {
        $query = $this->em->getRepository(ClientMiniReport::class)->findAllQuery();
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            self::NUMBER_ITEM_PER_PAGE
        );
        if (isset($pagination)) {
            return $this->successResponse($pagination);
        }
    }

    /**
     * @Rest\Get("/clientsminireport/{id}", name="client_mini_report_show_info_by_id")
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function showInfoPDV(int $id)
    {
        $clientMiniReport = $this->em->getRepository(ClientMiniReport::class)->customFind($id);
        if (isset($clientMiniReport)) {
            return $this->successResponse($clientMiniReport);
        }
    }

    /**
     * @Rest\Post("/clientsminireport/create", name="client_mini_report_create")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $jsonData = json_decode($request->getContent(),true);
        $etatClient =(int)$jsonData["etat_id"];
        $clientId =$jsonData["client_id"];
        $onePlanningId = $jsonData["one_planning_id"];
        $merchId = $jsonData["merch_id"];
        $numCycle = $jsonData["num_cycle"];
        // Test if Report is already exist
        $existMiniReportOfClient = $this->em->getRepository(ClientStateByCycleByDay::class)->findOneBy([
            "clientId"=>$clientId,
            "etatId"=>$etatClient,
            "OnePlanningId"=>$onePlanningId
        ]);

        if(isset($existMiniReportOfClient)){
            return $this->successResponse(["code"=>301,"message"=>" Report Client Exist!"]);
        }

        if($etatClient == 3){
            $statusReport = "Closed";
        }
        // Change the state to 3 = (client reporting)
        $this->changeStatusOfTheClientWhenExecuteReport($etatClient,$clientId,$onePlanningId);

        // Create Report (closed PDV)
        $clientMiniReport = new  ClientMiniReport();
        $reasonClosedClient =$jsonData["reason"];
        if(is_int($reasonClosedClient)){
            $clientMiniReport->setClosedReasonId($reasonClosedClient);
            $clientMiniReport->setClosedReasonAutre(null);
        }else{
            $clientMiniReport->setClosedReasonId(null);
            $clientMiniReport->setClosedReasonAutre($reasonClosedClient);
        }
        $clientMiniReport
            ->setDate(new \DateTime('NOW'))
            ->setMerchId($merchId)
            ->setClientId($clientId)
            ->setStatus($statusReport)
            ->setNumCycle($numCycle);
        $this->em->persist($clientMiniReport);
        $this->em->flush();
        return $this->successResponse(["code"=>200,"message"=>"Mini Report Created","report_id"=>$clientMiniReport->getId()]);
    }



    /**
     * @Rest\Post("/clientsminireport/{id}/create/images", name="client_mini_report_create_images")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createImages(Request $request, int $id)
    {
        $closedRepportObject = $this->em->getRepository(ClientMiniReport::class)->find($id);
        if(isset($closedRepportObject)) {

            /* $uplodedImage = $request->files->get('images');
             $fileUploader = new  FileUploader($this->getParameter('images_closed_repport_directory'));
             $fileName = $fileUploader->upload($uplodedImage);
             $pathProduct =  $_SERVER['HTTP_HOST'].'/uploads/merchsimage/'.$fileName;*/

            /*      $images =$_FILES["images"];
                  $target_dir = $this->getParameter('images_closed_repport_directory');
                  $fileName = basename($images["name"]);
                  $target_file = $target_dir .'/'.$fileName;
                  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                   move_uploaded_file($_FILES['images']['tmp_name'], $target_file);*/

            /*
                      try{

                            // Count total files
                            $countfiles = count($_FILES['images']['name']);
                            $target_dir = $this->getParameter('images_closed_repport_directory');
                            // Looping all files
                            for($i=0;$i<$countfiles;$i++){
                                $filename = $_FILES['images']['name'][$i];
                                $target_file = $target_dir .'/'.$filename;
                                move_uploaded_file($_FILES['images']['tmp_name'][$i], $target_file);
                                $pathProduct =  $_SERVER['HTTP_HOST'].'/uploads/minirapportimages/'.$filename;
                                $file = new File();
                                $file->setLabel($filename);
                                $file->setPath($pathProduct);
                                $file->setClientMiniReport($closedRepportObject);
                                $this->em->persist($file);
                                $this->em->flush();
                            }

                      }catch(\Exception $e){
                          error_log($e->getMessage());
                      }


                        //return $this->successResponse(["code"=>200,"message"=>"closed report images sended"]);
                        }else{
                        return $this->successResponse(["code"=>400,"message"=>"Err"]);
                    }*/

            //$up= $request->file('image')->store('images');
            //var_dump($up);die();
            if ($_FILES['images']) {
                $total = count($_FILES['images']['name']);

                for ($i = 0; $i < $total; $i++) {
                    $avatar_name = $_FILES["images"]["name"][$i];
                    $avatar_tmp_name = $_FILES["images"]["tmp_name"][$i];
                    $error = $_FILES["images"]["error"][$i];

                    try {
                        $target_dir = $this->getParameter('images_closed_repport_directory');
                        $random_name = rand(1000, 1000000) . "-" . $avatar_name;
                        $upload_name = $target_dir . strtolower($random_name);
                        $upload_name = preg_replace('/\s+/', '-', $upload_name);
                        $target_file = $target_dir .'/'.$avatar_name;
                        move_uploaded_file($avatar_tmp_name, $target_file);
                        $pathProduct =  $_SERVER['HTTP_HOST'].'/uploads/minirapportimages/'.$avatar_name;
                        $file = new File();
                        $file->setLabel($avatar_name);
                        $file->setPath($pathProduct);
                        $file->setClientMiniReport($closedRepportObject);
                        $this->em->persist($file);
                        $this->em->flush();
                    } catch (Exception $e) {
                       // echo json_encode($e);
                    }
                }

                $response = array(
                    "status" => "success",
                    "error" => false,
                    "message" => "File uploaded successfully",
                    "code" => "200"
                );
            } else {
                $response = array(
                    "status" => "error",
                    "error" => true,
                    "message" => "No file was sent!",
                    "code" => "501"
                );
            }
            return $this->successResponse($response);
        }


    }







    public function changeStatusOfTheClientWhenExecuteReport($var1,$var2,$var3)
    {
        $existClientState = $this->em->getRepository(ClientStateByCycleByDay::class)->findOneBy([
            "clientId"=>$var2,
            "OnePlanningId"=>$var3
        ]);
        if($existClientState){
            $existClientState
                ->setClientId($var2)
                ->setEtatId($var1)
                ->setOnePlanningId($var3);
            $this->em->persist($existClientState);
            $this->em->flush();
        }else{
            $clientState = new  ClientStateByCycleByDay();
            $clientState
                ->setClientId($var2)
                ->setEtatId($var1)
                ->setOnePlanningId($var3);
            $this->em->persist($clientState);
            $this->em->flush();
        }
        return null;
    }

    /**
     * @Rest\Delete("/clientsminireport/{id}/delete", name="clientsminireport_delete")
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $miniReport = $this->em->getRepository(ClientMiniReport::class)->find($id);
        if(isset($miniReport)){
            if($miniReport->getImagesClosedReport()){
                $images = $miniReport->getImagesClosedReport();
                foreach ($images as $image){
                    // unlink images from folder
                    $folder = $this->getParameter('images_closed_repport_directory');
                    $fileName = $folder.'/'.$image->getLabel();
                    if($fileName){
                        unlink($fileName);
                    }
                }
            }
            $this->em->remove($miniReport);
            $this->em->flush();
            return $this->successResponse(["code"=>200,"message"=>"Closed Mini Report Deleted"]);
        }
    }

}