<?php
namespace App\Controller\webservices;

use App\Entity\Deligation;
use App\Entity\Gouvernorat;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route ("api", name="api_")
 *
 */
class DeligationController extends  MainController
{
    /**
     * @Rest\Get("/deligation/showall", name="deligation_show_all")
     */
    public function index()
    {
        $deligation = $this->em->getRepository(Deligation::class)->customFindAll();
        if(isset($deligation)) {
            return $this->successResponse($deligation);
        }
    }

    /**
     * @Rest\Get("/deligation/{id}", name="deligation_show_by_id")
     * @return Response\
     */
    public function show(int $id)
    {
        $deligation = $this->em->getRepository(Deligation::class)->find($id);
        if(isset($deligation)) {
            return $this->successResponse($deligation);
        }
    }

    /**
     * @Rest\Post("/deligation/create", name="deligation_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $deligation = new  Deligation();
        $deligation->setLabel($request->request->get("label"));
        // get Gouvernorat by ID
        $gouvernorat = $this->em->getRepository(Gouvernorat::class)->find($request->request->get("gouvernorat_id"));
        $deligation->setGouvernorat($gouvernorat);
        $this->em->persist($deligation);
        $this->em->flush();
        return $this->successResponse($deligation);
    }

    /**
     * @Rest\Post("/deligation/{id}/update", name="deligation_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $deligation = $this->em->getRepository(Deligation::class)->find($id);
        if(isset($deligation)){
            $deligation->setLabel($request->request->get("label") ?? $deligation->getLabel());
            $this->em->persist($deligation);
            $this->em->flush();
            return $this->successResponse($deligation);
        }
    }

    /**
     * @Rest\Delete("/deligation/{id}/delete",name="deligation_delete")
     */
    public  function delete(Request $request, int $id)
    {
        $deligation = $this->em->getRepository(Deligation::class)->find($id);
        if(isset($deligation)) {
            $this->em->remove($deligation);
            $this->em->flush();
            return $this->successResponse($deligation);
        }
    }

}