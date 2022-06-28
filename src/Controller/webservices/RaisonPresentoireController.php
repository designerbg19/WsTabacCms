<?php
namespace App\Controller\webservices;

use App\Entity\RaisonPresontoire;
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
class RaisonPresentoireController  extends MainController
{
    /**
     * @Rest\Get("/raisonPresontoire", name="raisonPresontoire")
     */
    public function raisonPresontoire()
    {
        $raisonPresontoire = $this->em->getRepository(RaisonPresontoire::class)->findAll();
        if (isset($raisonPresontoire)) {
            return $this->successResponse($raisonPresontoire);
        }
    }

    /**
     * @Rest\Get("/raisonPresontoireBO", name="raisonPresontoireBO")
     */
    public function raisonPresontoireBO()
    {
        $raisonPresontoire = $this->em->getRepository(RaisonPresontoire::class)->raison();
        if (isset($raisonPresontoire)) {
            return $this->successResponse($raisonPresontoire);
        }
    }

    /**
     * @Rest\Post("/raisonPresontoireBO", name = "raisonPresontoireBO_create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $raisonPresontoire = new RaisonPresontoire();
        $raisonPresontoire->setRaison($request->request->get('label'));
        $this->em->persist($raisonPresontoire);
        $this->em->flush();
        $id=$raisonPresontoire->getId();
        $raisonPresontoire = $this->em->getRepository(RaisonPresontoire::class)->findOneByid($id);
        return $this->successResponse($raisonPresontoire[0]);
    }

    /**
     * @Rest\Post("/raisonPresontoireBO/{id}", name = "raisonPresontoireBO_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $raisonPresontoire = $this->em->getRepository(RaisonPresontoire::class)->find($id);
        $raisonPresontoire->setRaison($request->request->get('label'));
        $this->em->persist($raisonPresontoire);
        $this->em->flush();
        $idt=$raisonPresontoire->getId();
        $raisonPresontoire = $this->em->getRepository(RaisonPresontoire::class)->findOneByid($idt);
        return $this->successResponse($raisonPresontoire[0]);

    }

    /**
     * @Rest\Delete("/raisonPresontoireBO/{id}", name = "raisonPresontoireBO_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $raisonPresontoire = $this->em->getRepository(RaisonPresontoire::class)->find($id);
        if (isset($raisonPresontoire)) {
            $this->em->remove($raisonPresontoire);
            $this->em->flush();
            return $this->successResponse($raisonPresontoire);
        }
    }

}