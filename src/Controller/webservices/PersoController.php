<?php


namespace App\Controller\webservices;


use App\Entity\File;
use App\Entity\Photos;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Perso;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/*ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 1400);
ini_set('max_execution_time', 1400);*/
/**
 * @Route ("api", name="api_")
 *
 */
class PersoController extends  MainController
{

    /**
     * @Rest\Get("/perso/showall", name="perso_show_all")
     */
    public function index()
    {
        $perso = $this->em->getRepository(Perso::class)->findall();
        if (isset($perso)) {
            return $this->successResponse($perso);
        }
    }

    /**
     * @Rest\Post("/perso/create", name="perso_create")
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $perso = new  Perso();
        $perso->setName($request->request->get('name'));
        $this->em->persist($perso);
        $this->em->flush();
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
        //$filePath = $filePath . DIRECTORY_SEPARATOR . $fileName;
        $uploadedFiles = $request->files->get('imageFile');
        foreach ($uploadedFiles as $uploadedFile){
            //$filePath =
            $photo = new Photos();
            $photo->setImageFile($uploadedFile);
            $photo->setPerso($perso);
            $this->em->persist($photo);
            $this->em->flush();
        }


        return $this->successResponse("ok");
    }

    /**
     * @Rest\Delete("/perso/{id}/delete",name="pperso_delete")
     */
    public function delete(Request $request, int $id)
    {
        $perso = $this->em->getRepository(Perso::class)->find($id);
        if (isset($perso)) {
            $this->em->remove($perso);
            $this->em->flush();
            return $this->successResponse($perso);
        }
    }

}