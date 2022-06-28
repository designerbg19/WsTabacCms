<?php
namespace App\Controller\webservices;

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
class ZoneController extends MainController
{
    /**
     * @Rest\Get("/zone/showall",name = "zone_show_all")
     */
    public function index()
    {
        $zone = $this->em->getRepository(Zone::class)->customFindAll();
        if(isset($zone)) {
            return $this->successResponse($zone);
        }
    }

    /**
     * @Rest\Get("/zone/{id}", name = "zone_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $zone = $this->em->getRepository(Zone::class)->find($id);
        if(isset($zone)) {
            return $this->successResponse($zone);
        }
    }

    /**
     * @Rest\Post("/zone/create", name = "zone_create")
     * @param Request $request
     * @return Response
     */
    public function create( Request $request)
    {
        $zone = new Zone();
        $zone->setlabel($request->request->get('label'));
        $region = $this->em->getRepository(Region::class)->find($request->request->get('region_id'));
        $zone->setRegion($region);
        $this->em->persist($zone);
        $this->em->flush();
        return $this->successResponse($zone);
    }

    /**
     * @Rest\Post("/zone/{id}/update", name = "zone_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $zone = $this->em->getRepository(Zone::class)->find($id);
        if(isset($zone)) {
            $zone->setlabel($request->request->get('label'));
            $this->em->persist($zone);
            $this->em->flush();
            return $this->successResponse($zone);
        }
    }

    /**
     * @Rest\Delete("/zone/{id}/delete", name = "zone_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $zone = $this->em->getRepository(Zone::class)->find($id);
        if(isset($zone)) {
            $this->em->remove($zone);
            $this->em->flush();
            return $this->successResponse($zone);
        }
    }

}
