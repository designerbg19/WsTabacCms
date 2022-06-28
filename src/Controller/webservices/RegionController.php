<?php
namespace App\Controller\webservices;

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
class RegionController extends MainController
{
    /**
     * @Rest\Get("/region/showall",name = "region_show_all")
     */
    public function index()
    {
        $region = $this->em->getRepository(Region::class)->customFindAll();
        if(isset($region)) {
            return $this->successResponse($region);
        }
    }

    /**
     * @Rest\Get("/region/{id}", name = "region_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        //$region = $this->em->getRepository(Region::class)->find($id);
        //$serializer = SerializerBuilder::create()->build();
        //$data = $serializer->serialize($region, 'json');
       // echo($data);die;
        $region = $this->em->getRepository(Region::class)->find($id);
        if(isset($region)) {
            return $this->successResponse($region);
        }

    }

    /**
     * @Rest\Post("/region/create", name = "region_create")
     * @return Response
     */
    public function create( Request $request)
    {
        $region = new Region();
        $region->setlabel($request->request->get('label'));
        $this->em->persist($region);
        $this->em->flush();
        return $this->successResponse($region);
    }

    /**
     * @Rest\Post("/region/{id}/update", name = "region_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $region = $this->em->getRepository(Region::class)->find($id);
        if(isset($region)) {
            $region->setlabel($request->request->get('label') ?? $region->getLabel());
            $this->em->persist($region);
            $this->em->flush();
            return $this->successResponse($region);
        }
    }

    /**
     * @Rest\Delete("/region/{id}/delete", name = "region_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $region = $this->em->getRepository(Region::class)->find($id);
        if(isset($region)) {
            $this->em->remove($region);
            $this->em->flush();
            return $this->successResponse($region);
        }
    }

}