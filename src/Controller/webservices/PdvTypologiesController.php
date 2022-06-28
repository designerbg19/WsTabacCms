<?php
namespace App\Controller\webservices;

use App\Entity\PdvTypologies;
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
class PdvTypologiesController extends MainController
{
    /**
     * @Rest\Get("/pdvtypologies/showall", name="pdvtypologies_show_all")
     */
    public function index()
    {
        $pdvTypologies = $this->em->getRepository(PdvTypologies::class)->findall();
        if(isset($pdvTypologies)) {
            return $this->successResponse($pdvTypologies);
        }
    }

    /**
     * @Rest\Get("/pdvtypologies/{id}", name="pdvtypologies_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $pdvTypologies = $this->em->getRepository(PdvTypologies::class)->find($id);
        if(isset($pdvTypologies)) {
            return $this->successResponse($pdvTypologies);
        }
    }

    /**
     * @Rest\Post("/pdvtypologies/create", name="pdvtypologies_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $pdvTypologies = new  PdvTypologies();
        $pdvTypologies->setLabel($request->request->get("label"));
        $this->em->persist($pdvTypologies);
        $this->em->flush();
        return $this->successResponse($pdvTypologies);
    }

    /**
     * @Rest\Post("/pdvtypologies/{id}/update", name="pdvtypologies_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $pdvTypologies = $this->em->getRepository(PdvTypologies::class)->find($id);
        if(isset($pdvTypologies)) {
            $pdvTypologies->setLabel($request->request->get("label") ?? $pdvTypologies->getLabel());
            $this->em->persist($pdvTypologies);
            $this->em->flush();
            return $this->successResponse($pdvTypologies);
        }
    }

    /**
     * @Rest\Delete("/pdvtypologies/{id}/delete",name="pdvtypologies_delete")
     */
    public  function delete(Request $request, int $id)
    {
        $pdvTypologies = $this->em->getRepository(PdvTypologies::class)->find($id);
        if(isset($pdvTypologies)) {
            $this->em->remove($pdvTypologies);
            $this->em->flush();
            return $this->successResponse($pdvTypologies);
        }
    }

}