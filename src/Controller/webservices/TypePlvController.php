<?php
namespace App\Controller\webservices;

use App\Entity\QuantiterTypePlv;
use App\Entity\RaisonPresontoire;
use App\Entity\TypePlv;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\PdvPresentoire;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class TypePlvController  extends MainController
{
    /**
     * @Rest\Get("/PlvTemporaire", name="PlvTemporaire")
     */
    public function PlvTemporaire()
    {
        $typePlv = $this->em->getRepository(TypePlv::class)->findAll();
        $quantiterTypePlv = $this->em->getRepository(QuantiterTypePlv::class)->findAll();
        $plvTemporaire=[$typePlv,$quantiterTypePlv];
        if (isset($plvTemporaire)) {
            return $this->successResponse($plvTemporaire);
        }
    }


  /**
     * @Rest\Get("/PlvTemporaireBO", name="PlvTemporaireBO")
     */
    public function PlvTemporaireBO()
    {
        $typePlv = $this->em->getRepository(TypePlv::class)->type();
        if (isset($typePlv)) {
            return $this->successResponse($typePlv);
        }
    }



    /**
     * @Rest\Get("/PlvTemporaireBO/{id}", name = "PlvTemporaireBO_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function PlvTemporaireBO_id(int $id)
    {
        $PlvTemporaireBO = $this->em->getRepository(TypePlv::class)->typePLV_id($id);
        if (isset($PlvTemporaireBO)) {
            return $this->successResponse($PlvTemporaireBO);
        }
    }

    /**
     * @Rest\Post("/PlvTemporaireBO/create", name = "PlvTemporaireBO_create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $PlvTemporaireBO = new TypePlv();
        $PlvTemporaireBO->setType($request->request->get('label'));
        $this->em->persist($PlvTemporaireBO);
        $this->em->flush();
        $id=$PlvTemporaireBO->getId();
        $PlvTemporaireBO = $this->em->getRepository(TypePlv::class)->typePLV_id($id);

        return $this->successResponse($PlvTemporaireBO);
    }

    /**
     * @Rest\Post("/PlvTemporaireBO/{id}/update", name = "PlvTemporaireBO_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $PlvTemporaireBO = $this->em->getRepository(TypePlv::class)->find($id);
        if (isset($PlvTemporaireBO)) {
            $PlvTemporaireBO->setType($request->request->get('label'));
            $this->em->persist($PlvTemporaireBO);
            $this->em->flush();
            if (http_response_code(200) == true) {
                return $this->successResponse([
                    "code" => 200,
                    "message" => "PlvTemporaire  UPDATED ",
                    "PlvTemporaireBO" => $PlvTemporaireBO
                ]);
            } else {
                if (http_response_code(500) == true) {
                    return $this->successResponse(["message" => "erreur interne du serveur"]);
                } else {
                    return $this->successResponse([http_response_code()]);
                }
            }
        }
    }

    /**
     * @Rest\Delete("/PlvTemporaireBO/{id}/delete", name = "PlvTemporaireBO_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $PlvTemporaireBO = $this->em->getRepository(TypePlv::class)->find($id);
        if (isset($PlvTemporaireBO)) {
            $this->em->remove($PlvTemporaireBO);
            $this->em->flush();
            return $this->successResponse($PlvTemporaireBO);
        }
    }

}