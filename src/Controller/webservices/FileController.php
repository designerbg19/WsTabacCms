<?php

namespace App\Controller\webservices;

use App\Entity\File;
use App\Entity\Produit;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class FileController extends MainController
{
    /**
     * @Rest\Post("/TestImage", name="TestImage")
     * @return Response
     */
    public function TestImage(Request $request, FileUploader $fileUploader)
    {   // call To FileUpload service
        $em = $this->getDoctrine()->getManager();
        $file = $fileUploader->upload($request);
        $host = $request->getSchemeAndHttpHost() . $this->getParameter('imgBaseDir');
        $result = $fileUploader->ImageUploade($file,$em);
        dump($result);die();
        return $host;
    }
    /**
     * @Rest\Post("/TestImage2", name="TestImage2")
     * @return Response
     */
    public function TestImages(Request $request, FileUploader $fileUploader)
    {   // call To FileUpload service
        $file = $fileUploader->upload($request);
        // get The scheme and HTTP host
        $host = $request->getSchemeAndHttpHost() . $this->getParameter('imgBaseDir');
        // forech to set label image and return pathe
        foreach ($file as $key => $value) {//dump($value);die();
            if (is_array($value)) {
                $imagesPathes = [];
                foreach ($value as $label) {
                    $pathe = $host . "/" . $label;
                    $file = new File();
                    $file->setLabel($label);
                  //  $file->setPath($pathe);
                    $this->em->persist($file);
                    $this->em->flush();
                    // Collect All Pathes an Array and return it in the end
                    array_push($imagesPathes, $pathe);

                }
            }else{
                $file = new File();
                $file->setLabel($value);
                $this->em->persist($file);
                $this->em->flush();
                // Collect All Pathes an Array and return it in the end
                //array_push($imagesPathes, $pathe);
            }
        }
     //   return $imagesPathes;
    }


    /**
     * @Rest\Get("/files/showall", name="files_show_all")
     */
    public function index()
    {
        $files = $this->em->getRepository(File::class)->findall();
        if (isset($files)) {
            return $this->successResponse($files);
        }
    }

    /**
     * @Rest\Get("/files/{id}", name="files_show_by_id")
     */
    public function show($id)
    {
        $files = $this->em->getRepository(File::class)->find($id);
        if (isset($files)) {
            return $this->successResponse($files);
        }
    }

    /**
     * @Rest\Post("/files/create",name="files_create")
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $uploadedFile = $request->files->get('myFile');
        // Random Name File

        $generateFileName = md5(uniqid()) . '.' . $uploadedFile->getClientOriginalExtension();
        // Move File to the Directory
        $uploadedFile->move($this->getParameter('rapport_file_directory'), $generateFileName);
        // Send data to the Database
        $file = new File();
        $file->setLabel($generateFileName);
        // just the name
        $file->setPath($generateFileName);
        $file->setDateCreation(new \DateTime());
        $file->setClassment("1");
        //  $produit = $this->em->getRepository(Produit::class)->find($request->request->get("id_Produit"));
        //$file->setProduit($produit);
        $this->em->persist($file);
        $this->em->flush();
        // return response
        return $this->successResponse($file);
    }


    /**
     * @Rest\Post("/files/createBO",name="files_create")
     *
     * @return Response
     */
    public function createBO(Request $request)
    {
        $uploadedFile = $request->files->get('myFile');
        // Random Name File

        $generateFileName = md5(uniqid()) . '.' . $uploadedFile->getClientOriginalExtension();
        // Move File to the Directory
        $uploadedFile->move($this->getParameter('images_param_directory'), $generateFileName);
        // Send data to the Database
        $file = new File();
        $file->setLabel($generateFileName);
        // just the name
        $file->setPath($generateFileName);
        $file->setDateCreation(new \DateTime());
        $file->setClassment("1");
        //  $produit = $this->em->getRepository(Produit::class)->find($request->request->get("id_Produit"));
        //$file->setProduit($produit);
        $this->em->persist($file);
        $this->em->flush();
        $file_id = $file->getId();
        // return response
        return $this->successResponse($file_id);
    }

    /**
     * @Rest\Post("/files/update/{id}",name="files_update")
     *
     * @return Response
     */
    public function update(Request $request, int $id)
    {

        $file = $this->em->getRepository(File::class)->find($id);
        $uploadedFile = $request->files->get('myFile');
        // Random Name File
        $generateFileName = md5(uniqid()) . '.' . $uploadedFile->getClientOriginalExtension();
        // Move File to the Directory
        $uploadedFile->move($this->getParameter('rapport_file_directory'), $generateFileName);
        // Send data to the Database
        $file->setLabel($generateFileName);
        // path = name
        $file->setPath($generateFileName);
        $file->setDateCreation(new \DateTime());
        $file->setClassment("1");
        $this->em->persist($file);
        $this->em->flush();
        return $this->successResponse($file);
    }

}