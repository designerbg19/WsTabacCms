<?php
namespace App\Controller\webservices;

use App\Entity\Age;
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
class AgeController extends MainController
{
    /**
     * @Rest\Get("/age/showall",name = "Age_show_all")
     */
    public function index()
    {
        $Age = $this->em->getRepository(Age::class)->findage();
        if(isset($Age)) {
            return $this->successResponse($Age);
        }
    }

    /**
     * @Rest\Get("/age/{id}", name = "Age_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $Age = $this->em->getRepository(Age::class)->find($id);
        if(isset($Age)) {
            return $this->successResponse($Age);
        }
    }

    /**
     * @Rest\Post("/age/create", name = "Age_create")
     * @param Request $request
     * @return Response
     */
    public function create( Request $request)
    {
        $Age = new Age();
        $Age->setAge($request->request->get('label'));
        $this->em->persist($Age);
        $this->em->flush();
        return $this->successResponse(["id"=>$Age->getId(),"label"=>$Age->getAge()]);
    }

    /**
     * @Rest\Post("/age/{id}/update", name = "Age_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $Age = $this->em->getRepository(Age::class)->find($id);
        if(isset($Age)) {
            $Age->setAge($request->request->get('label'));
            $this->em->persist($Age);
            $this->em->flush();
            return $this->successResponse(["id"=>$Age->getId(),"label"=>$Age->getAge()]);
        }
    }

    /**
     * @Rest\Delete("/age/{id}/delete", name = "Age_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $Age = $this->em->getRepository(Age::class)->find($id);
        if(isset($Age)) {
            $this->em->remove($Age);
            $this->em->flush();
            return $this->successResponse(["code"=>200,"message"=>"Ok"]);
        }
    }

}