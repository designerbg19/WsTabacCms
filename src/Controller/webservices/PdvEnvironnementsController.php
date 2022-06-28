<?php
namespace App\Controller\webservices;

use App\Entity\PdvEnvironnements;
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
class PdvEnvironnementsController extends MainController
{
    /**
     * @Rest\Get("/pdvenvironnements/showall", name="pdvenvironnements_show_all")
     */
    public function index()
    {
        $pdvEnvironnements = $this->em->getRepository(PdvEnvironnements::class)->findall();
        if(isset($pdvEnvironnements)) {
            return $this->successResponse($pdvEnvironnements);
        }
    }

    /**
     * @Rest\Get("/pdvenvironnements/{id}", name="pdvenvironnements_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $pdvEnvironnements = $this->em->getRepository(PdvEnvironnements::class)->find($id);
        if(isset($pdvEnvironnements)) {
            return $this->successResponse($pdvEnvironnements);
        }
    }

    /**
     * @Rest\Post("/pdvenvironnements/create", name="pdvenvironnements_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $pdvEnvironnements = new  PdvEnvironnements();
        $pdvEnvironnements->setLabel($request->request->get("label"));
        $this->em->persist($pdvEnvironnements);
        $this->em->flush();
        return $this->successResponse($pdvEnvironnements);
    }

    /**
     * @Rest\Post("/pdvenvironnements/{id}/update", name="pdvenvironnements_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $pdvEnvironnements = $this->em->getRepository(PdvEnvironnements::class)->find($id);
        if(isset($pdvEnvironnements)) {
            $pdvEnvironnements->setLabel($request->request->get("label") ?? $pdvEnvironnements->getLabel());
            $this->em->persist($pdvEnvironnements);
            $this->em->flush();
            return $this->successResponse($pdvEnvironnements);
        }
    }

    /**
     * @Rest\Delete("/pdvenvironnements/{id}/delete",name="pdvenvironnements_delete")
     */
    public  function delete(Request $request, int $id)
    {
        $pdvEnvironnements = $this->em->getRepository(PdvEnvironnements::class)->find($id);
        if(isset($pdvEnvironnements)) {
            $this->em->remove($pdvEnvironnements);
            $this->em->flush();
            return $this->successResponse($pdvEnvironnements);
        }
    }

}