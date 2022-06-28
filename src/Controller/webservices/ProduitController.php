<?php

namespace App\Controller\webservices;

use App\Entity\Client;
use App\Entity\File;
use App\Entity\Produit;
use App\Entity\TypeProduit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class ProduitController extends MainController
{
    /**
     * @Rest\Get("/produit/showall", name="produit_show_all")
     */
    public function index()
    {
        $produit = $this->em->getRepository(Produit::class)->produit();
        if (isset($produit)) {
            return $this->successResponse($produit);
        }
    }

    /**
     * @Rest\Get("/produit/{id}", name="produit_show_by_id")
     * @return Response\
     */
    public function show(int $id)
    {
        $produit = $this->em->getRepository(Produit::class)->find($id);
        if (isset($produit)) {
            return $this->successResponse($produit);
        }
    }

    /**
     * @Rest\Post("/produit/create", name="produit_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $produit = new  Produit();

        $typeproduit = $this->em->getRepository(TypeProduit::class)->find($request->request->get("id_TypeProduit"));
        //  $client = $this->em->getRepository(Client::class)->find($request->request->get("id_Client"));
        $file = $this->em->getRepository(File::class)->find($request->request->get("id_File"));


        $produit->setTypeproduit($typeproduit);
        $produit->setFile($file);
        $produit->setIsVisible(true);
        $produit->setNom($request->request->get("nom"));
        $produit->setStoke($request->request->get("stoke"));
        $this->em->persist($produit);
        $this->em->flush();
        return $this->successResponse($produit);
    }

    /**
     * @Rest\Post("/produit/{id}/update", name="produit_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $produit = $this->em->getRepository(Produit::class)->find($id);
        $client = $this->em->getRepository(Client::class)->find($request->request->get("id_client"));
        if (isset($produit)) {
            $produit->addClient($client);
            $produit->setNom($request->request->get("nom") ?? $produit->getNom());
            $produit->setIsVisible($request->request->get("isVisible") ?? $produit->getIsVisible());
            //   $produit->setStokeMin($request->request->get("stokeMin") ?? $produit->getStokeMin());
            $produit->setTypeproduit($request->request->get("id_TypeProduit") ?? $produit->getTypeproduit());
            $produit->setFile($request->request->get("id_File") ?? $produit->getFile());

            $this->em->persist($produit);
            $this->em->flush();
            return $this->successResponse($produit);
        }
    }

    /**
     * @Rest\Delete("/produit/{id}/delete",name="produit_delete")
     */
    public function delete(Request $request, int $id)
    {
        $produit = $this->em->getRepository(Produit::class)->find($id);
        if (isset($produit)) {
            $this->em->remove($produit);
            $this->em->flush();
            return $this->successResponse($produit);
        }
    }

}