<?php
namespace App\Controller\webservices;

use App\Entity\MarketingRecette;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class MarketingRecetteController extends MainController
{
    /**
     * @Rest\Get("/mrecette/showall", name="mrecette_show_all")
     */
    public function index()
    {
        $mRecette = $this->em->getRepository(MarketingRecette::class)->findMark();
        if(isset($mRecette)) {
            return $this->successResponse($mRecette);
        }
    }

    /**
     * @Rest\Get("/mrecette/{id}", name="mrecette_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $mRecette = $this->em->getRepository(MarketingRecette::class)->find($id);
        if(isset($mRecette)) {
            return $this->successResponse($mRecette);
        }
    }

    /**
     * @Rest\Post("/mrecette/create", name="mrecette_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $mRecette = new  MarketingRecette();
        $mRecette->setRecetteList($request->request->get("label"));
        //$mRecette->setRecetteS(null);
       // $mRecette->setRecetteP(null);
        $this->em->persist($mRecette);
        $this->em->flush();
        return $this->successResponse($mRecette);
    }

    /**
     * @Rest\Post("/mrecette/{id}/update", name="mrecette_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $mRecette = $this->em->getRepository(MarketingRecette::class)->find($id);
        if(isset($mRecette)) {
            $mRecette->setRecetteList($request->request->get("label") ?? $mRecette->getRecetteList());
            $this->em->persist($mRecette);
            $this->em->flush();
            return $this->successResponse($mRecette);
        }
    }

    /**
     * @Rest\Delete("/mrecette/{id}/delete",name="mrecette_delete")
     */
    public  function delete(Request $request, int $id)
    {
        $mRecette = $this->em->getRepository(MarketingRecette::class)->find($id);
        if(isset($mRecette)) {
            $this->em->remove($mRecette);
            $this->em->flush();
            return $this->successResponse($mRecette);
        }
    }

}