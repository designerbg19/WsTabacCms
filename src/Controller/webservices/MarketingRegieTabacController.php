<?php
namespace App\Controller\webservices;

use App\Entity\MarketingRegieTabac;
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
class MarketingRegieTabacController extends MainController
{
    /**
     * @Rest\Get("/mregietabac/showall", name="mregietabac_show_all")
     */
    public function index()
    {
        $mRegieTabac = $this->em->getRepository(MarketingRegieTabac::class)->findall();
        if(isset($mRegieTabac)) {
            return $this->successResponse($mRegieTabac);
        }
    }
    
    /**
     * @Rest\Get("/mregietabac/{id}", name="mregietabac_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $mRegieTabac = $this->em->getRepository(MarketingRegieTabac::class)->find($id);
        if(isset($mRegieTabac)) {
            return $this->successResponse($mRegieTabac);
        }
    }

    /**
     * @Rest\Post("/mregietabac/create", name="mregietabac_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $mRegieTabac = new  MarketingRegieTabac();
        $mRegieTabac->setLabel($request->request->get("label"));
        $this->em->persist($mRegieTabac);
        $this->em->flush();
        return $this->successResponse($mRegieTabac);
    }

    /**
     * @Rest\Post("/mregietabac/{id}/update", name="mregietabac_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $mRegieTabac = $this->em->getRepository(MarketingRegieTabac::class)->find($id);
        if(isset($mRegieTabac)) {
            $mRegieTabac->setLabel($request->request->get("label") ?? $mRegieTabac->getLabel());
            $this->em->persist($mRegieTabac);
            $this->em->flush();
            return $this->successResponse($mRegieTabac);
        }
    }

    /**
     * @Rest\Delete("/mregietabac/{id}/delete",name="mregietabac_delete")
     */
    public  function delete(Request $request, int $id)
    {
        $mRegieTabac = $this->em->getRepository(MarketingRegieTabac::class)->find($id);
        if(isset($mRegieTabac)) {
            $this->em->remove($mRegieTabac);
            $this->em->flush();
            return $this->successResponse($mRegieTabac);
        }
    }

}