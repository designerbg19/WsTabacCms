<?php
namespace App\Controller\webservices;

use App\Entity\PdvRaison;
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
class PdvRaisonController extends MainController
{
    /**
     * @Rest\Get("/pdvraison", name="pdvraison_show_all")
     */
    public function index()
    {
        $pdvRaison = $this->em->getRepository(PdvRaison::class)->findall();
        if (isset($pdvRaison)) {
            return $this->successResponse($pdvRaison);
        }
    }

    /**
     * @Rest\Get("/pdvraison/{id}", name="pdvraison_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $pdvRaison = $this->em->getRepository(PdvRaison::class)->find($id);
        if (isset($pdvRaison)) {
            return $this->successResponse($pdvRaison);
        }
    }

    /**
     * @Rest\Post("/pdvraison", name="pdvraison_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $pdvRaison = new  PdvRaison();
        $pdvRaison->setLabel($request->request->get("label"));
        $this->em->persist($pdvRaison);
        $this->em->flush();
        return $this->successResponse($pdvRaison);
    }

    /**
     * @Rest\Post("/pdvraison/{id}", name="pdvraison_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $pdvRaison = $this->em->getRepository(PdvRaison::class)->find($id);
        if(isset($pdvRaison)) {
            $pdvRaison->setLabel($request->request->get("label") ?? $pdvRaison->getLabel());
            $this->em->persist($pdvRaison);
            $this->em->flush();
            return $this->successResponse($pdvRaison);
        }
    }

    /**
     * @Rest\Delete("/pdvraison/{id}",name="pdvraison_delete")
     */
    public function delete(Request $request, int $id)
    {
        $pdvRaison = $this->em->getRepository(PdvRaison::class)->find($id);
        if (isset($pdvRaison)) {
            $this->em->remove($pdvRaison);
            $this->em->flush();
            return $this->successResponse($pdvRaison);
        }
    }

}