<?php

namespace App\Controller\webservices;

use App\Entity\GlobalPlanning;
use App\Entity\Merch;
use App\Entity\File;
use App\Entity\Region;
use App\Service\FileUploader;
use FOS\RestBundle\Controller\Annotations as Rest;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * @Route ("api", name="api_")
 *
 */
class MerchController extends MainController
{
    /**
     * @Rest\Get("/merchs/showall", name="merch_show_all")
     * @return Response
     */
    public function index()
    {
        $merchs = $this->em->getRepository(Merch::class)->customFindAll();
        if (isset($merchs)) {
            return $this->successResponse($merchs);
        }
    }

    /**
     * @Rest\Get("/merchs/showallpagination", name="merch_show_all_with_pagination")
     * @return Response
     */
    public function findMerchsWithPagination(Request $request)
    {
        $query = $this->em->getRepository(Merch::class)->customFindAllQuery();
        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            self::NUMBER_ITEM_PER_PAGE /*limit per page*/
        );
        if (isset($pagination)) {
            return $this->successResponse($pagination);
        }
    }

    /**
     * @Rest\Get("/merchs/{id}", name="merch_show_by_id")
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $merchs = $this->em->getRepository(Merch::class)->customFind($id);
        if (isset($merchs)) {
            return $this->successResponse($merchs);
        }
    }

    /**
     * @Rest\Post("/merchs/create", name="merch_create")
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request, UserPasswordEncoderInterface $encoder,UploaderHelper $helper)
    {

        $code = $request->request->get('code');
        // Check User if exist
        $merch = $this->em->getRepository(Merch::class)->findOneBy([
            "code" => $code,
        ]);
        if (!is_null($merch)) {
            return $this->successResponse(["code" => 409, "message" => "Code Merch already exist!"]);
        }
        $merch = new Merch();
        $merch->setCode($code);
        $merch->setFirstName($request->request->get('firstName'));
        $merch->setLastName($request->request->get('lastName'));
        $password = "default";
        $merch->setPassword(
            $this->passwordEncoder->encodePassword($merch, $password)
        );
        $merch->setPasswordEncrypted(
            $this->passwordEncoder->encodePassword($merch, $password)
        );

        // Get File and Region By ID
        if($request->files->get('images')){
            $merch->setImageFileMerch($request->files->get('images'));
        }else{
            $merch->setImageFileMerch(null);
        }

        if ($request->request->get('regionId')) {
            $region = $this->em->getRepository(Region::class)->find($request->request->get('regionId'));
            if (isset($region)) {
                $merch->setRegion($region);
            }
        }
        $merch->setRoles(array("ROLE_MERCH"));
        $this->em->persist($merch);
        // get the UploaderHelper service...
        if($request->files->get('images')){
            $path =  $helper->asset($merch, 'imageFileMerch');
            //$merch->setPathImage($_SERVER['HTTP_HOST'].'/images/merchs/'.$merch->getImageName());
            $merch->setPathImage('/images/merchs/'.$merch->getImageName());
        }
        $this->em->flush();
        $merchCustomShowForBO = $this->em->getRepository(Merch::class)->customFindById($merch->getId());
        return $this->successResponse(["code" => 200, "message" => "Merch Created", "merch" => $merchCustomShowForBO]);
    }

    /**
     * @Rest\Get("/merchs/{code}/image", name="merch_image")
     * @return Response
     *
     */
    public function showMerchPhoto(int $code){
        $merch = $this->em->getRepository(Merch::class)->findOneBy([
            "code" => $code,
        ]);
        if(isset($merch)){
            $imagePath = 'http://'.$_SERVER['HTTP_HOST'].''.$merch->getPathImage();
            return $this->successResponse(["code"=>200,"message"=>$imagePath]);
        }
        else{
            return $this->successResponse(["code"=>409,"message"=>"Merch Code Not Exist"]);
        }

    }


    /**
     * Generate Password automatique for merch with (id)
     * @Rest\Get("/merchs/create/password/{id}", name="merch_create_password")
     * @param $id
     * @return Response
     */
    public function createPassword($id)
    {
        $merch = $this->em->getRepository(Merch::class)->find($id);
        $password = $this->randomPassword(4);
        $encrypted = $this->encryptIt($password);
        $merch->setPassword($this->passwordEncoder->encodePassword($merch, $password));
        $strAddToEncryptedPassword = ($this->randomPassword(16)) . '' . $encrypted;
        $merch->setPasswordEncrypted($strAddToEncryptedPassword);
        $this->em->persist($merch);
        $this->em->flush();
        return $this->successResponse(["status" => 200, "message" => "Password Generated"]);
    }

    /**
     * Show Password of merch with (id)
     * @Rest\Get("/merchs/show/password/{id}", name="merch_show_password")
     * @param $id
     * @return Response
     */
    public function showPassword($id)
    {
        $merch = $this->em->getRepository(Merch::class)->find($id);
        if (isset($merch)) {
            $decrypted = $this->decryptIt($merch->getPasswordEncrypted());
            if (!$decrypted == '') {
                return $this->successResponse([
                    "merch_password" => $decrypted,
                ]);
            }
        }
        return $this->successResponse(["status" => 204, "message" => "No Content"]);
    }

    /**
     * @Rest\Post("/merchs/{id}/update", name="Merch_update")
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function update(Request $request, int $id,UploaderHelper $helper)
    {
        $merch = $this->em->getRepository(Merch::class)->find($id);
        if (isset($merch)) {
            // Get File

            if ($request->files->get('images')) {
                $merch->setImageFileMerch($request->files->get('images'));
                $merch->setUpdatedAt(new \DateTime('NOW'));
            } else {
                $merch->setImageFileMerch($merch->getImageFileMerch());
            }
            // Get Region By ID
            if ($request->request->get('regionId')) {
                $region = $this->em->getRepository(Region::class)->find($request->request->get('regionId'));
                if (isset($region)) {
                    $merch->setRegion($region ?? $merch->getRegion());
                }
            }
            $merch->setCode($request->request->get('code') ?? $merch->getCode());
            $merch->setFirstName($request->request->get('firstName') ?? $merch->getFirstName());
            $merch->setLastName($request->request->get('lastName') ?? $merch->getlastName());
            $merch->setPassword($merch->getPassword());
            $merch->setPasswordEncrypted($merch->getPasswordEncrypted());
            $this->em->persist($merch);
            $this->em->flush();
            // get the UploaderHelper service...
            if($request->files->get('images')){
                $path =  $helper->asset($merch, 'imageFileMerch');
                //$merch->setPathImage($_SERVER['HTTP_HOST'].'/images/merchs/'.$merch->getImageName());
                $merch->setPathImage('/images/merchs/'.$merch->getImageName());
            }else{
                $merch->setPathImage( $merch->getPathImage());
            }
            $this->em->flush();
            $merchCustomShowForBO = $this->em->getRepository(Merch::class)->customFindById($merch->getId());
            return $this->successResponse([
                "code" => 200,
                "message" => "Merch Updated",
                "merch" => $merchCustomShowForBO
            ]);
        } else {
            return $this->successResponse(["code" => 201, "message" => "No Content"]);
        }
    }

    /**
     * @Rest\delete("/merchs/{id}/delete", name="Merch_delete")
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $merchs = $this->em->getRepository(Merch::class)->find($id);
        if (isset($merchs)) {
            // delete planning of merch
            $planning = $this->em->getRepository(GlobalPlanning::class)->findOneBy(["merchId" => $id]);
            if (isset($planning)) {
                $this->em->remove($planning);
                $this->em->flush();
            }
            //Than delete the merch
            $this->em->remove($merchs);
            $this->em->flush();
            return $this->successResponse(["code" => 200, "message" => "MERCH DELETED"]);
        }
    }


    /***** upload csv clients with routings *****/
    /**
     * Upload Csv data (code -titulaire nom- code routing) attributes
     *
     * @Rest\Post("/merchs/upload/csv", name="merch_upload_csv")
     * @return Response
     * @throws \League\Csv\Exception
     */
    public function uploadCsv(Request $request)
    {
        $uplodedCsvFile = $request->files->get('file');
        $csvName = $uplodedCsvFile->getClientOriginalName();
        $typeFile = explode('.', $csvName)[1];
        if ($typeFile !== "csv") {
            return $this->successResponse(["code" => 409, "message" => "Please Uploded CSV File (.csv)"]);
        }
        $fileUploader = new  FileUploader($this->getParameter('csv_data_upload_directory'));
        $fileName = $fileUploader->upload($uplodedCsvFile);
        $filePath = $this->getParameter('csv_data_upload_directory') . '/' . $fileName;

        //Test static file : $filePath = $this->getParameter('csv_data_upload_directory') . '/merchs10.csv';
        //load the CSV document from a stream
        $stream = fopen($filePath, 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setHeaderOffset(0);

        //query your records from the document
        $records = $csv->getRecords();
        foreach ($records as $key => $record) {
            if (!isset($record["Code"]) or !isset($record["Nom"]) or !isset($record["Prenom"])) {
                return $this->successResponse([
                    "code" => 409,
                    "message" => "Check Titles :: Must  like (Code) (Nom) (Prenom)"
                ]);
            }

            $code = $record["Code"];
            $firstname = $record["Nom"];
            $lastname = $record["Prenom"];

            // The format of Code like (00)
            $regxCodeMerch = '/^\d{1,5}$/';

            // Test if code format is correct
            if (preg_match($regxCodeMerch, $code)) {

                //Check if Merch Exist in database by the Code
                $existMerch = $this->em->getRepository(Merch::class)->findOneBy([
                    "code" => $code
                ]);

                // If client exist in the database
                if (isset($existMerch)) {
                    $redundancy[] = [
                        "ligne" => $key + 1,
                        "Code" => $code,
                        "Nom" => $firstname,
                        "Prenom" => $lastname
                    ];
                } else {
                    //create new Merch
                    $this->createMerch($code, $firstname, $lastname);
                }

                // Else (if the Merch code with rong format) return the ligne of error
            } else {
                $errors[] = [
                    "ligne" => $key + 1,
                    "Code" => $code,
                    "Nom" => $firstname,
                    "Prenom" => $lastname,
                    "comment" => "Check Code, must be Integer < 99999"
                ];
            }

        }

        // Response
        if (empty($errors)) {
            $errors[] = null;
        }
        if (empty($redundancy)) {
            $redundancy[] = null;
        }

        // Delete the csv file from folder after saving the data into Database
        unlink($filePath);

        return $this->successResponse([
            "code" => 200,
            "message" => "Merch CSV Uploded ",
            "errorsInCodeMerch" => $errors,
            "redundancy" => $redundancy
        ]);

    }

    /**
     * Function to create Merch from CSV File (code/nom/prenom)
     * @param $code
     * @param $firstname
     * @param $lastname
     */
    private function createMerch($code, $firstname, $lastname)
    {
        $newMerch = new Merch();
        $newMerch->setCode((int)$code);
        $newMerch->setFirstName($firstname);
        $newMerch->setLastName($lastname);
        $newMerch->setRoles(array("ROLE_MERCH"));
        $password = "default";
        $newMerch->setPassword(
            $this->passwordEncoder->encodePassword($newMerch, $password)
        );
        $newMerch->setPasswordEncrypted(
            $this->passwordEncoder->encodePassword($newMerch, $password)
        );
        $this->em->persist($newMerch);
        $this->em->flush();
    }


}