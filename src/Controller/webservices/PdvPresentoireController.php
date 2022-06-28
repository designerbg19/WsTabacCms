<?php

namespace App\Controller\webservices;

use App\Entity\File;
use App\Entity\PraisontoirMaisonDeMaire;
use App\Service\FileUploader;
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
class PdvPresentoireController extends MainController
{
    /**
     * @Rest\Get("/pdvPresentoireJti", name="pdvPresentoireJti")
     */
    public function pdvPresentoireJti()
    {
        $pdvPresentoire = $this->em->getRepository(PdvPresentoire::class)->findprsentoireJti();
        if (isset($pdvPresentoire)) {
            return $this->successResponse($pdvPresentoire);
        }
    }

    /**
     * @Rest\Get("/pdvPresentoireNotJti", name="pdvPresentoireNotJti")
     */
    public function pdvPresentoireNotJti()
    {
        $pdvPresentoire = $this->em->getRepository(PdvPresentoire::class)->findprsentoireNotJti();
        if (isset($pdvPresentoire)) {
            return $this->successResponse($pdvPresentoire);
        }
    }


    ///////////////////
    ///
    /**
     * @Rest\Get("/pdvPresentoireJtiBo", name="pdvPresentoireJtibo")
     * @author youssef
     */
    public function pdvPresentoireJtiBo()
    {
        $pdvPresentoire = $this->em->getRepository(PdvPresentoire::class)->findPresontoireJtiOrNotJti(true);
        if (isset($pdvPresentoire)) {
            return $this->successResponse($pdvPresentoire);
        }
    }

    /**
     * @Rest\Get("/pdvPresentoireNotJtiBo", name="pdvPresentoireNotJtibo")
     * @author youssef
     */
    public function pdvPresentoireNotJtiBo()
    {
        $pdvPresentoire = $this->em->getRepository(PdvPresentoire::class)->findPresontoireJtiOrNotJti(false);
        if (isset($pdvPresentoire)) {
            return $this->successResponse($pdvPresentoire);
        }
    }

    /**
     * @Rest\Get("/pdvpresentoire/showall", name="pdvpresentoire_show_all")
     */
    public function index()
    {
        $pdvPresentoire = $this->em->getRepository(PdvPresentoire::class)->findall();
        if (isset($pdvPresentoire)) {
            return $this->successResponse($pdvPresentoire);
        }
    }

    /**
     * @Rest\Get("/pdvpresentoire/showallBO", name="pdvpresentoire_showallBO")
     */
    public function showallBO()
    {
        $pdvPresentoire = $this->em->getRepository(PdvPresentoire::class)->findprsentoireJtiBO();
        if (isset($pdvPresentoire)) {
            return $this->successResponse($pdvPresentoire);
        }
    }

    /**
     * @Rest\Get("/pdvpresentoire/{id}", name="pdvpresentoire_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $pdvPresentoire = $this->em->getRepository(PdvPresentoire::class)->findById($id);
        if (isset($pdvPresentoire)) {
            return $this->successResponse($pdvPresentoire);
        }
    }

    /**
     * @Rest\Post("/pdvpresentoire/create", name="pdvpresentoire_create")
     * @return Response
     */
    public function create(Request $request)
    {
        if ($request->request->get("isJti") === "true") {
            $pdvPresentoire = new  PdvPresentoire();
            $pdvPresentoire->setIsJti(true);
            $pdvPresentoire->setLabel($request->request->get("label"));
            $uplodedImage = $request->files->get('myFile');
            $this->saveImageFilePresontoire($pdvPresentoire, $uplodedImage);


        } else {
            $pdvPresentoire = new  PdvPresentoire();
            $pdvPresentoire->setIsJti(false);
            $pdvPresentoire->setLabel($request->request->get("label"));
            $uplodedImage = $request->files->get('myFile');
            $this->saveImageFilePresontoire($pdvPresentoire, $uplodedImage);
            $PraisontoirMaisonDeMaire_id = $request->request->get("PraisontoirMaisonDeMaire_id");
            $PraisontoirMaisonDeMaire = $this->em->getRepository(PraisontoirMaisonDeMaire::class)->find($PraisontoirMaisonDeMaire_id);
            $pdvPresentoire->setPraisontoirMaisonDeMaire($PraisontoirMaisonDeMaire);
        }
        $this->em->persist($pdvPresentoire);
        $this->em->flush();
        //return $this->successResponse(["code"=>200,"message"=>"Presentoire Created","object"=>$pdvPresentoire);
        return $this->show($pdvPresentoire->getId());
    }

    /**
     * @Rest\Post("/pdvpresentoire/{id}/update", name="pdvpresentoire_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $pdvPresentoire = $this->em->getRepository(PdvPresentoire::class)->find($id);
        $oldFile = $pdvPresentoire->getImage();
        if (isset($pdvPresentoire)) {
            if ($request->request->get("isJti") === "true") {
                $pdvPresentoire->setLabel(($request->request->get("label")) ?? $pdvPresentoire->getLabel());
                if ($request->files->get("myFile")) {
                    // create new image
                    $uplodedImage = $request->files->get('myFile');
                    $this->saveImageFilePresontoire($pdvPresentoire, $uplodedImage);
                }
            } else {
                $pdvPresentoire->setLabel(($request->request->get("label")) ?? $pdvPresentoire->getLabel());
                if ($request->files->get("myFile")) {
                    // create new image
                    $uplodedImage = $request->files->get('myFile');
                    $this->saveImageFilePresontoire($pdvPresentoire, $uplodedImage);
                }
                if ($request->request->get("PraisontoirMaisonDeMaire_id") ?? $pdvPresentoire->getPraisontoirMaisonDeMaire()) {
                    $PraisontoirMaisonDeMaire_id = $request->request->get("PraisontoirMaisonDeMaire_id");
                    $PraisontoirMaisonDeMaire = $this->em->getRepository(PraisontoirMaisonDeMaire::class)->find($PraisontoirMaisonDeMaire_id);
                    $pdvPresentoire->setPraisontoirMaisonDeMaire($PraisontoirMaisonDeMaire);
                }
            }

            $this->em->persist($pdvPresentoire);
            $this->em->flush();
            //delete old photo
            if ($request->files->get("myFile")) {
                $this->em->remove($oldFile);
                $this->em->flush();
            }
            return $this->show($pdvPresentoire->getId());
        }
    }

    /**
     * @Rest\Delete("/pdvpresentoire/{id}/delete",name="pdvpresentoire_delete")
     */
    public function delete(int $id)
    {
        $pdvPresentoire = $this->em->getRepository(PdvPresentoire::class)->find($id);
        if ($pdvPresentoire) {
            //unlink Image from folder If Exist
            $this->unlinkParamsImage($pdvPresentoire);
            $this->em->remove($pdvPresentoire);
            $this->em->flush();
            return $this->successResponse(["code" => 200, "message" => "Presontoire Deleted"]);
        }
    }



}