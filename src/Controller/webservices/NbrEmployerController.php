<?php
namespace App\Controller\webservices;

use App\Entity\Age;
use App\Entity\NbrEmployer;
use App\Entity\NbrEnfant;
use App\Entity\SituationFamilialle;
use App\Entity\Zone;
use App\Entity\Region;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api", name="api_")
 *
 */
class NbrEmployerController extends MainController
{
    /**
     * @Rest\Get("/NbrEmployer/showall",name = "NbrEmployer_show_all")
     */
    public function index()
    {
        $NbrEmployer = $this->em->getRepository(NbrEmployer::class)->findnbrEmpolyer();
        if(isset($NbrEmployer)) {
            return $this->successResponse($NbrEmployer);
        }
    }

    /**
     * @Rest\Get("/NbrEmployer/{id}", name = "NbrEmployer_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $NbrEmployer = $this->em->getRepository(NbrEmployer::class)->find($id);
        if(isset($NbrEmployer)) {
            return $this->successResponse($NbrEmployer);
        }
    }

    /**
     * @Rest\Post("/NbrEmployer/create", name = "NbrEmployer_create")
     * @param Request $request
     * @return Response
     */
    public function create( Request $request)
    {
        $NbrEmployer = new NbrEmployer();
        $NbrEmployer->setNbremployer($request->request->get('label'));
        $this->em->persist($NbrEmployer);
        $this->em->flush();
        return $this->successResponse($NbrEmployer);
    }

    /**
     * @Rest\Post("/NbrEmployer/{id}/update", name = "NbrEmployer_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $NbrEmployer = $this->em->getRepository(NbrEmployer::class)->find($id);
        if(isset($NbrEnfant)) {
            $NbrEmployer->setNbrEmployer($request->request->get('label'));
            $this->em->persist($NbrEmployer);
            $this->em->flush();
            return $this->successResponse($NbrEmployer);
        }
    }

    /**
     * @Rest\Delete("/NbrEmployer/{id}/delete", name = "NbrEmployer_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $NbrEmployer = $this->em->getRepository(NbrEmployer::class)->find($id);
        if(isset($NbrEmployer)) {
            $this->em->remove($NbrEmployer);
            $this->em->flush();
            return $this->successResponse($NbrEmployer);
        }
    }

}