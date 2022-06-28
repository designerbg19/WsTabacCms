<?php
namespace App\Controller\webservices;

use App\Entity\Age;
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
class NbrEnfantController extends MainController
{
    /**
     * @Rest\Get("/nbrenfant/showall",name = "NbrEnfant_show_all")
     */
    public function index()
    {
        $NbrEnfant = $this->em->getRepository(NbrEnfant::class)->findnbEnf();
        if(isset($NbrEnfant)) {
            return $this->successResponse($NbrEnfant);
        }
    }

    /**
     * @Rest\Get("/nbrenfant/{id}", name = "NbrEnfant_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $NbrEnfant = $this->em->getRepository(NbrEnfant::class)->find($id);
        if(isset($NbrEnfant)) {
            return $this->successResponse($NbrEnfant);
        }
    }

    /**
     * @Rest\Post("/nbrenfant/create", name = "NbrEnfant_create")
     * @param Request $request
     * @return Response
     */
    public function create( Request $request)
    {
        $NbrEnfant = new NbrEnfant();
        $NbrEnfant->setNbrEnfant($request->request->get('label'));
        $this->em->persist($NbrEnfant);
        $this->em->flush();
        return $this->successResponse(["id"=>$NbrEnfant->getId(),"label"=>$NbrEnfant->getNbrEnfant()]);
    }

    /**
     * @Rest\Post("/nbrenfant/{id}/update", name = "NbrEnfant_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $NbrEnfant = $this->em->getRepository(NbrEnfant::class)->find($id);
        if(isset($NbrEnfant)) {
            $NbrEnfant->setAge($request->request->get('label'));
            $this->em->persist($NbrEnfant);
            $this->em->flush();
            return $this->successResponse(["id"=>$NbrEnfant->getId(),"label"=>$NbrEnfant->getNbrEnfant()]);
        }
    }

    /**
     * @Rest\Delete("/nbrenfant/{id}/delete", name = "NbrEnfant_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $NbrEnfant = $this->em->getRepository(NbrEnfant::class)->find($id);
        if(isset($NbrEnfant)) {
            $this->em->remove($NbrEnfant);
            $this->em->flush();
            return $this->successResponse(["code"=>200,"message"=>"Ok"]);
        }
    }

}