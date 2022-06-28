<?php
namespace App\Controller\webservices;

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
class SituatioFamilialeController extends MainController
{
    /**
     * @Rest\Get("/situationfamilialle/showall",name = "SituationFamilialle_show_all")
     */
    public function index()
    {
        $SituationFamilialle = $this->em->getRepository(SituationFamilialle::class)->findSituation();
        if(isset($SituationFamilialle)) {
            return $this->successResponse($SituationFamilialle);
        }
    }

    /**
     * @Rest\Get("/situationfamilialle/{id}", name = "SituationFamilialle_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $SituationFamilialle = $this->em->getRepository(SituationFamilialle::class)->find($id);
        if(isset($SituationFamilialle)) {
            return $this->successResponse($SituationFamilialle);
        }
    }

    /**
     * @Rest\Post("/situationfamilialle/create", name = "SituationFamilialle_create")
     * @param Request $request
     * @return Response
     */
    public function create( Request $request)
    {
        $SituationFamilialle = new SituationFamilialle();
        $SituationFamilialle->setsitation($request->request->get('label'));
        $this->em->persist($SituationFamilialle);
        $this->em->flush();
        return $this->successResponse(["id"=>$SituationFamilialle->getId(),"label"=>$SituationFamilialle->getSitation()]);
    }

    /**
     * @Rest\Post("/situationfamilialle/{id}/update", name = "SituationFamilialle_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $SituationFamilialle = $this->em->getRepository(SituationFamilialle::class)->find($id);
        if(isset($zone)) {
            $SituationFamilialle->setsituation($request->request->get('label'));
            $this->em->persist($SituationFamilialle);
            $this->em->flush();
            return $this->successResponse(["id"=>$SituationFamilialle->getId(),"label"=>$SituationFamilialle->getSitation()]);
        }
    }

    /**
     * @Rest\Delete("/situationfamilialle/{id}/delete", name = "SituationFamilialle_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $SituationFamilialle = $this->em->getRepository(SituationFamilialle::class)->find($id);
        if(isset($SituationFamilialle)) {
            $this->em->remove($SituationFamilialle);
            $this->em->flush();
            return $this->successResponse(["code"=>200,"message"=>"Ok"]);
        }
    }

}