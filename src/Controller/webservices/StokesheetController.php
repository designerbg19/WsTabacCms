<?php
namespace App\Controller\webservices;

use App\Entity\Age;
use App\Entity\Client;
use App\Entity\Produit;
use App\Entity\SituationFamilialle;
use App\Entity\StokeSheet;
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
class StokesheetController extends MainController
{
    /**
     * @Rest\Get("/StokeSheet",name = "StokeSheet_show_all")
     */
    public function index()
    {
        $StokeSheet = $this->em->getRepository(StokeSheet::class)->findAll();
        if(isset($StokeSheet)) {
            return $this->successResponse($StokeSheet);
        }
    }

    /**
     * @Rest\Get("/StokeSheet/{id}", name = "StokeSheet_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $StokeSheet = $this->em->getRepository(StokeSheet::class)->find($id);
        if(isset($StokeSheet)) {
            return $this->successResponse($StokeSheet);
        }
    }

    /**
     * @Rest\Post("/StokeSheet", name = "StokeSheet_create")
     * @param Request $request
     * @return Response
     */
    public function create( Request $request)
    {
        $produit = $this->em->getRepository(Produit::class)->find($request->request->get('produit_id'));
        $client = $this->em->getRepository(Client::class)->find($request->request->get('client_id'));
        $StokeSheet = new StokeSheet();
        $StokeSheet->setStokeSheet($request->request->get('label'));
        $StokeSheet->setProduit($produit);
        $StokeSheet->setClient($client);

        $this->em->persist($StokeSheet);
        $this->em->flush();
        return $this->successResponse($StokeSheet);
    }

    /**
     * @Rest\Post("/StokeSheet/{id}", name = "StokeSheet_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $StokeSheet = $this->em->getRepository(StokeSheet::class)->find($id);
        if(isset($StokeSheet)) {
            $StokeSheet->setAge($request->request->get('label'));
            $this->em->persist($StokeSheet);
            $this->em->flush();
            return $this->successResponse($StokeSheet);
        }
    }

    /**
     * @Rest\Delete("/StokeSheet/{id}", name = "StokeSheet_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $StokeSheet = $this->em->getRepository(StokeSheet::class)->find($id);
        if(isset($StokeSheet)) {
            $this->em->remove($StokeSheet);
            $this->em->flush();
            return $this->successResponse($StokeSheet);
        }
    }

}