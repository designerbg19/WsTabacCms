<?php

namespace App\Controller\webservices;

use App\Entity\File;
use App\Entity\PdvShop;
use App\Entity\PdvTPOSM;
use App\Entity\RaisonPresontoire;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\PdvPresentoire;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class PdvTPOSMController extends MainController
{
    /**
     * @Rest\Get("/PdvTPOSM", name="PdvTPOSM")
     */
    public function PdvTPOSM()
    {
        $PdvTPOSM = $this->em->getRepository(PdvTPOSM::class)->tposmBO();

        if (isset($PdvTPOSM)) {
            return $this->successResponse($PdvTPOSM);
        }
    }


    /**
     * @Rest\Get("/PdvTPOSM/{id}", name = "PdvTPOSM_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function PdvTPOSM_id(int $id)
    {
        $PdvTPOSM = $this->em->getRepository(PdvTPOSM::class)->PdvTPOSM_id($id);
        if (isset($PdvTPOSM)) {
            return $this->successResponse($PdvTPOSM);
        }
    }

    /**
     * @Rest\Get("/PdvTPOSMBo/{id}", name="PdvTPOSMBoBo_show_by_Id_bo")
     * @author youssef
     */
    public function show(int $id)
    {
        $pdvTposm = $this->em->getRepository(PdvTPOSM::class)->findTposmById($id);
        if (isset($pdvTposm)) {
            return $this->successResponse($pdvTposm);
        }
    }

    /**
     * @Rest\Post("/PdvTPOSM/create", name = "pdvTposmBo_create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $PdvTPOSM = new PdvTPOSM();
        $PdvTPOSM->setNom($request->request->get('label'));
        $uplodedImage = $request->files->get('myFile');
        $this->saveImageFilePresontoire($PdvTPOSM,$uplodedImage);
        $this->em->persist($PdvTPOSM);
        $this->em->flush();
        return $this->show($PdvTPOSM->getId());
    }

    /**
     * @Rest\Post("/PdvTPOSM/{id}/update", name = "pdvTposmBo_update_bo", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $pdvTposm = $this->em->getRepository(PdvTPOSM::class)->find($id);
        $oldFile= $pdvTposm->getImage();
        if (isset($pdvTposm)) {
            $pdvTposm->setNom($request->request->get('label'));
            if ($request->files->get("myFile")) {
                $uplodedImage = $request->files->get('myFile');
                $this->saveImageFilePresontoire($pdvTposm, $uplodedImage);
            }
            $this->em->persist($pdvTposm);
            $this->em->flush();
            //delete old photo
            if ($request->files->get("myFile")) {
                $this->em->remove($oldFile);
                $this->em->flush();
            }
            return $this->show($pdvTposm->getId());
        }

    }

    /**
     * @Rest\Delete("/PdvTPOSM/{id}/delete", name = "PdvTPOSMbo_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $pdvTposm = $this->em->getRepository(PdvTPOSM::class)->find($id);
        if ($pdvTposm) {
            //unlink Image from folder If Exist
            $this->unlinkParamsImage($pdvTposm);
            $this->em->remove($pdvTposm);
            $this->em->flush();
            return $this->successResponse(["code"=>200,"message"=>"TPOSM DELETED"]);
        }else{
            return $this->successResponse(["code"=>204,"message"=>"No Content"]);
        }
    }



}