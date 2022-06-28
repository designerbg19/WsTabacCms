<?php
namespace App\Controller\webservices;

use App\Entity\Deligation;
use App\Entity\Quartier;
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
class QuartierController extends MainController
{
    /**
     * @Rest\Get("/quartier/showall", name="quartier_show_all")
     */
    public function index()
    {
        $quartier = $this->em->getRepository(Quartier::class)->customFindAll();
        if(isset($quartier)) {
            return $this->successResponse($quartier);
        }
    }

    /**
     * @Rest\Get("/quartier/{id}", name="quartier_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $quartier = $this->em->getRepository(Quartier::class)->find($id);
        if(isset($quartier)) {
            return $this->successResponse($quartier);
        }
    }

    /**
     * @Rest\Post("/quartier/create", name="quartier_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $quartier = new  quartier();
        $quartier->setLabel($request->request->get("label"));
        // Get Deligation By ID
        $deligation = $this->em->getRepository(Deligation::class)->find($request->request->get("deligation_id"));
        $quartier->setDeligation($deligation);
        $this->em->persist($quartier);
        $this->em->flush();
        return $this->successResponse($quartier);
    }

    /**
     * @Rest\Post("/quartier/{id}/update", name="quartier_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $quartier = $this->em->getRepository(Quartier::class)->find($id);
        if (isset($quartier)) {
            $quartier->setLabel($request->request->get("label") ?? $quartier->getLabel());
            $this->em->persist($quartier);
            $this->em->flush();
            return $this->successResponse($quartier);
        }
    }

    /**
     * @Rest\Delete("/quartier/{id}/delete",name="quartier_delete")
     */
    public  function delete(Request $request, int $id)
    {
        $quartier = $this->em->getRepository(Quartier::class)->find($id);
        if(isset($quartier)) {
            $this->em->remove($quartier);
            $this->em->flush();
            return $this->successResponse($quartier);
        }
    }

}