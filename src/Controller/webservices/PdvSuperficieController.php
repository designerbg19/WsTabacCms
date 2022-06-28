<?php
namespace App\Controller\webservices;

use App\Entity\PdvSuperficie;
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
class PdvSuperficieController extends MainController
{
    /**
     * @Rest\Get("/pdvsuperficie/showall", name="pdvsuperficie_show_all")
     */
    public function index()
    {
        $pdvSuperficie = $this->em->getRepository(PdvSuperficie::class)->findall();
        if(isset($pdvSuperficie)){
            return $this->successResponse($pdvSuperficie);
        }
    }

    /**
     * @Rest\Get("/pdvsuperficie/{id}", name="pdvsuperficie_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $pdvSuperficie = $this->em->getRepository(PdvSuperficie::class)->find($id);
        if(isset($pdvSuperficie)) {
            return $this->successResponse($pdvSuperficie);
        }
    }

    /**
     * @Rest\Post("/pdvsuperficie/create", name="pdvsuperficie_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $pdvSuperficie = new  PdvSuperficie();
        $pdvSuperficie->setLabel($request->request->get("label"));
        $this->em->persist($pdvSuperficie);
        $this->em->flush();
        return $this->successResponse($pdvSuperficie);
    }

    /**
     * @Rest\Post("/pdvsuperficie/{id}/update", name="pdvsuperficie_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $pdvSuperficie = $this->em->getRepository(PdvSuperficie::class)->find($id);
        if(isset($pdvSuperficie)) {
            $pdvSuperficie->setLabel($request->request->get("label") ?? $pdvSuperficie->getLabel());
            $this->em->persist($pdvSuperficie);
            $this->em->flush();
            return $this->successResponse($pdvSuperficie);
        }
    }

    /**
     * @Rest\Delete("/pdvsuperficie/{id}/delete",name="pdvsuperficie_delete")
     */
    public  function delete(Request $request, int $id)
    {
        $pdvSuperficie = $this->em->getRepository(PdvSuperficie::class)->find($id);
        if(isset($pdvSuperficie)) {
            $this->em->remove($pdvSuperficie);
            $this->em->flush();
            return $this->successResponse($pdvSuperficie);
        }
    }

}