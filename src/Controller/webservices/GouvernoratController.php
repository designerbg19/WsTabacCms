<?php
namespace App\Controller\webservices;

use App\Entity\Gouvernorat;
use App\Entity\Zone;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route ("api", name="api_")
 *
 */
class GouvernoratController extends MainController
{
    /**
     * @Rest\Get("/gouvernorat/showall", name="gouvernorat_show_all")
     */
    public function index()
    {
        $gouvernorat = $this->em->getRepository(Gouvernorat::class)->customFindAll();
        if(isset($gouvernorat)) {
            return $this->successResponse($gouvernorat);
        }
    }

    /**
     * @Rest\Get("/gouvernorat/{id}", name="gouvernorat_show_by_id")
     * @return Response\
     */
    public function show(int $id)
    {
        $gouvernorat = $this->em->getRepository(Gouvernorat::class)->find($id);
        if(isset($gouvernorat)) {
            return $this->successResponse($gouvernorat);
        }
    }

    /**
     * @Rest\Post("/gouvernorat/create", name="gouvernorat_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $gouvernorat = new  Gouvernorat();
        $gouvernorat->setLabel($request->request->get("label"));
        // Get Zone By ID
        $zone = $this->em->getRepository(Zone::class)->find($request->request->get("zone_id"));
        $gouvernorat->setZone($zone);
        $this->em->persist($gouvernorat);
        $this->em->flush();
        return $this->successResponse($gouvernorat);
    }

    /**
     * @Rest\Post("/gouvernorat/{id}/update", name="gouvernorat_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $gouvernorat = $this->em->getRepository(Gouvernorat::class)->find($id);
        if(isset($gouvernorat)) {
            $gouvernorat->setLabel($request->request->get("label") ?? $gouvernorat->getLabel());
            $this->em->persist($gouvernorat);
            $this->em->flush();
            return $this->successResponse($gouvernorat);
        }
    }

    /**
     * @Rest\Delete("/gouvernorat/{id}/delete",name="gouvernorat_delete")
     */
    public  function delete(Request $request, int $id)
    {
        $gouvernorat = $this->em->getRepository(Gouvernorat::class)->find($id);
        if(isset($gouvernorat)) {
            $this->em->remove($gouvernorat);
            $this->em->flush();
            return $this->successResponse($gouvernorat);
        }
    }

}