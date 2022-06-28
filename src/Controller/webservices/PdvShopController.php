<?php

namespace App\Controller\webservices;

use App\Entity\File;
use App\Entity\PdvShop;
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
class PdvShopController extends MainController
{
    /**
     * @Rest\Get("/pdvShop", name="pdvShop")
     */
    public function pdvShop()
    {
        $pdvShop = $this->em->getRepository(PdvShop::class)->shop();
        if (isset($pdvShop)) {
            return $this->successResponse($pdvShop);
        }
    }

    /**
     * @Rest\Get("/pdvShopBo", name="pdvShopBo_showall")
     * @author youssef
     */
    public function pdvShopBo()
    {
        $pdvShop = $this->em->getRepository(PdvShop::class)->findAllShopBo();
        if (isset($pdvShop)) {
            return $this->successResponse($pdvShop);
        }
    }

    /**
     * @Rest\Get("/pdvShop/{id}", name = "pdvShop_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function showbyId(int $id)
    {
        $pdvShop = $this->em->getRepository(PdvShop::class)->shop_id($id);
        if (isset($pdvShop)) {
            return $this->successResponse($pdvShop);
        }
    }



    /**
     * @Rest\Get("/pdvShopBo/{id}", name="pdvShopBo_show_by_Id")
     * @author youssef
     */
    public function show(int $id)
    {
        $pdvShop = $this->em->getRepository(PdvShop::class)->findShopById($id);
        if (isset($pdvShop)) {
            return $this->successResponse($pdvShop);
        }
    }

    /**
     * @Rest\Post("/pdvShopBo/create", name = "pdvShop_create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $pdvShop = new PdvShop();
        $pdvShop->setShop($request->request->get('label'));
        $uplodedImage = $request->files->get('myFile');
        $this->saveImageFilePresontoire($pdvShop,$uplodedImage);
        $this->em->persist($pdvShop);
        $this->em->flush();
        return $this->show($pdvShop->getId());
    }

    /**
     * @Rest\Post("/pdvShopBo/{id}/update", name = "pdvShop_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $pdvShop = $this->em->getRepository(PdvShop::class)->find($id);
        $oldFile= $pdvShop->getImage();
        if (isset($pdvShop)) {
            $pdvShop->setShop($request->request->get('label'));
            if ($request->files->get("myFile")) {
                $uplodedImage = $request->files->get('myFile');
                $this->saveImageFilePresontoire($pdvShop, $uplodedImage);
            }
            $this->em->persist($pdvShop);
            $this->em->flush();
            //delete old photo
            if ($request->files->get("myFile")) {
                $this->em->remove($oldFile);
                $this->em->flush();
            }
            return $this->show($pdvShop->getId());
        }


    }

    /**
     * @Rest\Delete("/pdvShopBo/{id}/delete", name = "pdvShop_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $pdvShop = $this->em->getRepository(PdvShop::class)->find($id);
        if ($pdvShop) {
            //unlink Image from folder If Exist
            $this->unlinkParamsImage($pdvShop);
            $this->em->remove($pdvShop);
            $this->em->flush();
            return $this->successResponse(["code"=>200,"message"=>"shop deleted"]);
        }
    }


}