<?php
namespace App\Controller\webservices;

use App\Entity\PdvEmplacements;
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
class PdvEmplacementsController extends MainController
{
    /**
     * @Rest\Get("/pdvemplacements/showall", name="pdvemplacements_show_all")
     */
    public function index()
    {
        $pdvEmplacements = $this->em->getRepository(PdvEmplacements::class)->findall();
        if(isset($pdvEmplacements)) {
            return $this->successResponse($pdvEmplacements);
        }
    }
    
    /**
     * @Rest\Get("/pdvemplacements/{id}", name="pdvemplacements_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $pdvEmplacements = $this->em->getRepository(PdvEmplacements::class)->find($id);
        if(isset($pdvEmplacements)) {
            return $this->successResponse($pdvEmplacements);
        }
    }

    /**
     * @Rest\Post("/pdvemplacements/create", name="pdvemplacements_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $pdvEmplacements = new  PdvEmplacements();
        $pdvEmplacements->setLabel($request->request->get("label"));
        $this->em->persist($pdvEmplacements);
        $this->em->flush();
        return $this->successResponse($pdvEmplacements);
    }

    /**
     * @Rest\Post("/pdvemplacements/{id}/update", name="pdvemplacements_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $pdvEmplacements = $this->em->getRepository(PdvEmplacements::class)->find($id);
        if(isset($pdvEmplacements)) {
            $pdvEmplacements->setLabel($request->request->get("label") ?? $pdvEmplacements->getLabel());
            $this->em->persist($pdvEmplacements);
            $this->em->flush();
            return $this->successResponse($pdvEmplacements);
        }
    }

    /**
     * @Rest\Delete("/pdvemplacements/{id}/delete",name="pdvemplacements_delete")
     */
    public  function delete(Request $request, int $id)
    {
        $pdvEmplacements = $this->em->getRepository(PdvEmplacements::class)->find($id);
        if(isset($pdvEmplacements)) {
            $this->em->remove($pdvEmplacements);
            $this->em->flush();
            return $this->successResponse($pdvEmplacements);
        }
    }

}