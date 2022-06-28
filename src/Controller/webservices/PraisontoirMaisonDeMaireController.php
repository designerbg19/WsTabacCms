<?php
namespace App\Controller\webservices;

use App\Entity\PraisontoirMaisonDeMaire;
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
class PraisontoirMaisonDeMaireController extends MainController
{
    /**
     * @Rest\Get("/PraisontoirMaisonDeMaire/showall",name = "PraisontoirMaisonDeMaire_show_all")
     */
    public function index()
    {
        $PraisontoirMaisonDeMaire = $this->em->getRepository(PraisontoirMaisonDeMaire::class)->PraisontoirMaisonDeMaireShowALLBO();
        if(isset($PraisontoirMaisonDeMaire)) {
            return $this->successResponse($PraisontoirMaisonDeMaire);
        }
    }

    /**
     * @Rest\Get("/PraisontoirMaisonDeMaire/{id}", name = "PraisontoirMaisonDeMaireshow_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $PraisontoirMaisonDeMaire = $this->em->getRepository(PraisontoirMaisonDeMaire::class)->findOneByid($id);
        if(isset($PraisontoirMaisonDeMaire)) {
            return $this->successResponse($PraisontoirMaisonDeMaire);
        }
    }

    /**
     * @Rest\Post("/PraisontoirMaisonDeMaire/create", name = "PraisontoirMaisonDeMaire_create")
     * @param Request $request
     * @return Response
     */
    public function create( Request $request)
    {
        $PraisontoirMaisonDeMaire = new PraisontoirMaisonDeMaire();
        $PraisontoirMaisonDeMaire->setIsJti(false);
        $PraisontoirMaisonDeMaire->setMaisonDeMaire($request->request->get('label'));
        $this->em->persist($PraisontoirMaisonDeMaire);
        $this->em->flush();
        return $this->successResponse($PraisontoirMaisonDeMaire);
    }

    /**
     * @Rest\Post("/PraisontoirMaisonDeMaire/{id}/update", name = "PraisontoirMaisonDeMaire_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $PraisontoirMaisonDeMaire = $this->em->getRepository(PraisontoirMaisonDeMaire::class)->find($id);
        if(isset($PraisontoirMaisonDeMaire)) {
            $PraisontoirMaisonDeMaire->setMaisonDeMaire($request->request->get('label'));
            $this->em->persist($PraisontoirMaisonDeMaire);
            $this->em->flush();
            return $this->successResponse($PraisontoirMaisonDeMaire);
        }
    }

    /**
     * @Rest\Delete("/PraisontoirMaisonDeMaire/{id}/delete", name = "PraisontoirMaisonDeMaire_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $PraisontoirMaisonDeMaire = $this->em->getRepository(PraisontoirMaisonDeMaire::class)->find($id);
        if(isset($PraisontoirMaisonDeMaire)) {
            $this->em->remove($PraisontoirMaisonDeMaire);
            $this->em->flush();
            return $this->successResponse($PraisontoirMaisonDeMaire);
        }
    }

}
