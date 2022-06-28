<?php

namespace App\Controller\webservices;

use App\Entity\TypeProduit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class TypeProduitController extends MainController
{
    /**
     * @Rest\Get("/typeproduit/showall", name="typeproduit_show_all")
     */
    public function index()
    {
        $typeJti = $this->em->getRepository(TypeProduit::class)->typeJti();
        $typeNotJti = $this->em->getRepository(TypeProduit::class)->typeNotJti();
        $typeproduit = ["typeNotJTI" => $typeNotJti, "typeJTI" => $typeJti];
        if (isset($typeproduit)) {
            return $this->successResponse($typeproduit);
        }
    }


    /**
     * @Rest\Get("/typeproduit/showallBO", name="typeproduit_show_allBO")
     */
    public function indexBo()
    {
        $typeJti = $this->em->getRepository(TypeProduit::class)->typeJtiBO();
        $typeNotJti = $this->em->getRepository(TypeProduit::class)->typeNotJtiBO();
        $typeproduit = ["typeNotJTI" => $typeNotJti, "typeJTI" => $typeJti];
        if (isset($typeproduit)) {
            return $this->successResponse($typeproduit);
        }
    }

    /**
     * @Rest\Get("/typeproduit/{id}", name="typeproduit_show_by_id")
     * @return Response\
     */
    public function show(int $id)
    {
        $typeproduit = $this->em->getRepository(TypeProduit::class)->find($id);
        if (isset($typeproduit)) {
            return $this->successResponse($typeproduit);
        }
    }

    /**
     * @Rest\Post("/typeproduit/create", name="typeproduit_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $typeproduit = new  TypeProduit();
        $typeproduit->setType($request->request->get("type"));
        $typeproduit->setIsJti($request->request->get("isJti"));
        $this->em->persist($typeproduit);
        $this->em->flush();
        return $this->successResponse($typeproduit);
    }

    /**
     * @Rest\Post("/typeproduit/{id}/update", name="typeproduit_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $typeproduit = $this->em->getRepository(TypeProduit::class)->find($id);
        if (isset($typeproduit)) {
            $typeproduit->setType($request->get("type") ?? $typeproduit->gettype());
            $typeproduit->setIsJti($request->get("isJti") ?? $typeproduit->getIsJti());
            $this->em->persist($typeproduit);
            $this->em->flush();
            return $this->successResponse($typeproduit);
        }
    }

    /**
     * @Rest\Delete("/typeproduit/{id}/delete",name="typeproduit_delete")
     */
    public function delete(Request $request, int $id)
    {
        $typeproduit = $this->em->getRepository(TypeProduit::class)->find($id);
        if (isset($typeproduit)) {
            $this->em->remove($typeproduit);
            $this->em->flush();
            return $this->successResponse($typeproduit);
        }
    }

}