<?php
namespace App\Controller\webservices;

use App\Entity\PdvTypesQuartier;
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
class PdvTypesQuartierController extends MainController
{
    /**
     * @Rest\Get("/pdvtypesquartier/showall", name="pdvtypesquartier_show_all")
     */
    public function index()
    {
        $pdvTypesQuartier = $this->em->getRepository(PdvTypesQuartier::class)->findall();
        if(isset($pdvTypesQuartier)) {
            return $this->successResponse($pdvTypesQuartier);
        }
    }

    /**
     * @Rest\Get("/pdvtypesquartier/{id}", name="pdvtypesquartier_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $pdvTypesQuartier = $this->em->getRepository(PdvTypesQuartier::class)->find($id);
        if(isset($pdvTypesQuartier)) {
            return $this->successResponse($pdvTypesQuartier);
        }
    }

    /**
     * @Rest\Post("/pdvtypesquartier/create", name="pdvtypesquartier_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $pdvTypesQuartier = new  PdvTypesQuartier();
        $pdvTypesQuartier->setLabel($request->request->get("label"));
        $this->em->persist($pdvTypesQuartier);
        $this->em->flush();
        return $this->successResponse($pdvTypesQuartier);
    }

    /**
     * @Rest\Post("/pdvtypesquartier/{id}/update", name="pdvtypesquartier_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $pdvTypesQuartier = $this->em->getRepository(PdvTypesQuartier::class)->find($id);
        if(isset($pdvTypesQuartier)){
            $pdvTypesQuartier->setLabel($request->request->get("label") ?? $pdvTypesQuartier->getLabel());
            $this->em->persist($pdvTypesQuartier);
            $this->em->flush();
            return $this->successResponse($pdvTypesQuartier);
        }
    }

    /**
     * @Rest\Delete("/pdvtypesquartier/{id}/delete",name="pdvtypesquartier_delete")
     */
    public  function delete(Request $request, int $id)
    {
        $pdvTypesQuartier = $this->em->getRepository(PdvTypesQuartier::class)->find($id);
        if(isset($pdvTypesQuartier)) {
            $this->em->remove($pdvTypesQuartier);
            $this->em->flush();
            return $this->successResponse($pdvTypesQuartier);
        }
    }

}