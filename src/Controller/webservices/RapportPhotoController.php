<?php

namespace App\Controller\webservices;


use App\Entity\File;


use App\Service\Base64FileExtractor;
use App\Service\FileUploader;
use App\Service\UploadedBase64File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class RapportPhotoController extends MainController
{

    /**
     * @Rest\Post("/Aimen", name="Aimen")
     * @return Response
     */
    public function RapportPhotoController(Request $request)
    {

      //  $target_dir = $this->getParameter('rapport_file_directory');
        header('Content-Type: multipart/form-data');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: PUT, GET, POST");
        // Image Upload SetUP
        // $client_sheet = $this->em->getRepository(Client::class)->find(1);

          $target_dir = $this->getParameter('rapport_file_directory');
        //foreach ($_FILES as $fil){print_r($fil);}
        //  $content = json_decode($request->getContent(), true);
        //$images = $content['images'];


        // print_r($total);
        //  die();
        if ($_FILES['images']) {
            $total = \count($_FILES['images']['name']);
            for ($i = 0; $i < $total; $i++) {
                // File upload path
                $fileName = basename($_FILES['images']['name'][$i]);
                $avatar_name = $_FILES["images"]["name"][$i];
                $avatar_tmp_name = $_FILES["images"]["tmp_name"][$i];
                $error = $_FILES["images"]["error"][$i];
                $targetFilePath = $target_dir . '/' . $fileName;
                try {

                    $random_name = rand(1000, 1000000) . "-" . $avatar_name;
                    $upload_name = $targetFilePath . strtolower($random_name);
                    $upload_name = preg_replace('/\s+/', '-', $targetFilePath);
                    move_uploaded_file($avatar_tmp_name, $upload_name);
                    //  $FileNameRapport = '-RapportPdv-' . $fileName;
                    /*  $file = new File();
                      $file->setLabel($fileName);
                      $file->setPath($targetFilePath);
                      $this->em->persist($file);
                      $this->em->flush();*/

                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                } catch (\Exception $e) {
                    echo json_encode($e);
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
        // Upload file to server

       // return $response;
     return $this->successResponse(["code" => 200, "message" => "rapportDebutVisit saved"]);
    }

    /**
     * @Rest\Post("/images", name="app_add_image")
     * @return Response
     */
    public function addImage(Request $request, Base64FileExtractor $base64FileExtractor)
    {
            $file = new File();
            $base64Image = $request->request->get('base64Image');
            $base64Image = $base64FileExtractor->extractBase64String($base64Image);
            $imageFile = new UploadedBase64File($base64Image, "NewImage");
            $file->setPath($imageFile);
            $this->em->persist($file);
            $this->em->flush();

        return $file;

    }

}
