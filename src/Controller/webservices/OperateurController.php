<?php
namespace App\Controller\webservices;

use App\Entity\Operateur;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class OperateurController extends MainController
{
    /**
     * @Rest\Get("/operateur", name="operateur_show")
     * @return Response
     */
    public function index()
    {
        $operateur = $this->em->getRepository(Operateur::class)->findAll();
        if (isset($operateur)) {
            return $this->successResponse($operateur);
        }
    }

    /**
     * @Rest\Get("/operateur/{id}", name="operateur_show_by_id")
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $operateur = $this->em->getRepository(Operateur::class)->find($id);
        if (isset($operateur)) {
            return $this->successResponse($operateur);
        }
    }

    /**
 * @Rest\Post("/operateur", name="operateur_create")
 * @return Response
 */
    public function create(Request $request)
    {
        $operateur = new Operateur();
        $operateur->setNom($request->request->get("nom"));
        $operateur->setTelephone($request->request->get("telephone"));
        $this->em->persist($operateur);
        $this->em->flush();
        return $this->successResponse($operateur);
    }

    /**
     * @Rest\Post("/operateur/{id}", name="operateur_update")
     * @param int $id
     * @return Response
     */
    public function update(Request $request,int $id)
    {
        $operateur = $this->em->getRepository(Operateur::class)->find($id);
        if(isset($operateur)) {
            $operateur->setNom($request->request->get("nom") ?? $operateur->getNom());
            $operateur->setTelephone($request->request->get("telephone") ?? $operateur->getTelephone());
            $this->em->persist($operateur);
            $this->em->flush();
            return $this->successResponse($operateur);
        }
    }

    /**
     * @Rest\delete("/operateur/{id}", name="operateur_delete")
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, int $id)
    {
        $operateur = $this->em->getRepository(Operateur::class)->find($id);
        if(isset($operateur)) {
            $this->em->remove($operateur);
            $this->em->flush();
            return $this->successResponse($operateur);
        }
    }

}