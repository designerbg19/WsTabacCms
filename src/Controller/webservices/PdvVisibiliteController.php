<?php
namespace App\Controller\webservices;

use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\PdvVisibilite;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class PdvVisibiliteController extends MainController
{
    /**
     * @Rest\Get("/pdvvisibilite/showall", name="pdvvisibilite_show_all")
     */
    public function index()
    {
        $pdvVisibilite = $this->em->getRepository(PdvVisibilite::class)->findall();
        if (isset($pdvVisibilite)) {
            return $this->successResponse($pdvVisibilite);
        }
    }

    /**
     * @Rest\Get("/pdvvisibilite/{id}", name="pdvvisibilite_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $pdvVisibilite = $this->em->getRepository(PdvVisibilite::class)->find($id);
        if (isset($pdvVisibilite)) {
            return $this->successResponse($pdvVisibilite);
        }
    }

    /**
     * @Rest\Post("/pdvvisibilite/create", name="pdvvisibilite_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $pdvVisibilite = new  PdvVisibilite();
        $pdvVisibilite->setLabel($request->request->get("label"));
        $this->em->persist($pdvVisibilite);
        $this->em->flush();
        return $this->successResponse($pdvVisibilite);
    }

    /**
     * @Rest\Post("/pdvvisibilite/{id}/update", name="pdvvisibilite_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $pdvVisibilite = $this->em->getRepository(PdvVisibilite::class)->find($id);
        if(isset($pdvVisibilite)) {
            $pdvVisibilite->setLabel($request->request->get("label") ?? $pdvVisibilite->getLabel());
            $this->em->persist($pdvVisibilite);
            $this->em->flush();
            return $this->successResponse($pdvVisibilite);
        }
    }

    /**
     * @Rest\Delete("/pdvvisibilite/{id}/delete",name="pdvvisibilite_delete")
     */
    public function delete(Request $request, int $id)
    {
        $pdvVisibilite = $this->em->getRepository(PdvVisibilite::class)->find($id);
        if (isset($pdvVisibilite)) {
            $this->em->remove($pdvVisibilite);
            $this->em->flush();
            return $this->successResponse($pdvVisibilite);
        }
    }

}