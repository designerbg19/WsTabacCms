<?php

namespace App\Controller\webservices;

use App\Entity\Client;
use App\Entity\File;
use App\Entity\Produit;
use App\Entity\Stoke;
use App\Entity\StokeContainer;
use App\Entity\TypeProduit;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route ("api", name="api_")
 *
 */
class ProduitBOController extends MainController
{
    /**
     * @Rest\Get("/produitbo/showall", name="produitbo_show_all")
     */
    public function index()
    {
        $produit = $this->em->getRepository(Produit::class)->produitBo();
        if (isset($produit)) {
            return $this->successResponse($produit);
        }
    }

    /**
     * @Rest\Get("/produitbo/{id}", name="produitbo_show_by_id")
     * @return Response\
     */
    public function show(int $id)
    {
        $produit = $this->em->getRepository(Produit::class)->find($id);
        if (isset($produit)) {
            return $this->successResponse($produit);
        }
    }

    public function UpImage(Request $request, FileUploader $fileUploader)
    {   // call To FileUpload service
        $file = $fileUploader->upload($request);
        $host = $request->getSchemeAndHttpHost() . $this->getParameter('imgBaseDir');
        $result = $fileUploader->ImageUploade($file,$host);
        dump($host.$result['image']);die();
        return $host;
    }

    /**
     * @Rest\Post("/produitbo/create", name="produitbo_create")
     * @return Response
     */
    public function create(Request $request, FileUploader $fileUploader)
    {

        $ProduitTest = $this->em->getRepository(Produit::class)->findBy(['nom' => $request->request->get("label")]);
        if (empty($ProduitTest)) {
            $produit = new  Produit();
            $produit->setNom($request->request->get('label'));
            $produit->setColor($request->request->get('codeCouleur'));

            $typeproduit = $this->em->getRepository(TypeProduit::class)->find($request->request->get("type"));
            $produit->setTypeproduit($typeproduit);
            $produit->setIsVisible($request->request->get('is_visible'));
           // Ulpload  Files Part 
           //call To FileUpload service

             $file = $fileUploader->upload($request);
             $host = $request->getSchemeAndHttpHost() . $this->getParameter('imgBaseDir');
             $NewFile = $fileUploader->ImageUploade($file,$host);
              dump($host.$NewFile['image']);die();
            /*$uplodedImage = $request->files->get('path');
            $fileUploader = new  FileUploader($this->getParameter('image_product_directory'));
            $fileName = $fileUploader->upload($uplodedImage);
            $path = '/uploads/product/' . $fileName;
            $file = new File();
            $file->setLabel($fileName);
            $file->setPath($path);
            $this->em->persist($file);
            $this->em->flush();*/
            //

            $produit->setFile($NewFile);
            $this->em->persist($produit);
            $this->em->flush();


            /// Stoke =================================================================
            $id_prod = $produit->getId();
            if (isset($id_prod)) {
                $produit = $this->em->getRepository(Produit::class)->find($id_prod);

                // verify is this product Jti or not
                $is_Jti_Get = $this->em->getRepository(Produit::class)->produitIs_JTI($id_prod);
                $is_JTI = $is_Jti_Get[0]['isJti'];

                if ($is_JTI) {
                    $AllStokesContainerId = $this->em->getRepository(StokeContainer::class)->getAll_Id();

                    foreach ($AllStokesContainerId as $element) {
                        foreach ($element as $idStokeContainer) {

                            // $stoke = $this->em->getRepository(Stoke::class)->find($idStoke);
                            // $idContainer =$stoke->getStokeContainer()->getId();
                            //  $container= $stoke->getStokeContainer();

                            $StokeContainer = $this->em->getRepository(StokeContainer::class)->find($idStokeContainer);//dump($StokeContainer);die();
                            $stoke = new Stoke();
                            $stoke->setProduit($produit);
                            $stoke->setQuantiter(0);
                            $stoke->setStokeContainer($StokeContainer);

                        }
                        $this->em->persist($stoke);
                        $this->em->flush();
                        // dump($stoke);
                        // die();
                    }

                }
                // $produitCostomBO = $this->em->getRepository(Produit::class)->findProduitBOById($produit->getId());
                return $this->successResponse([
                    "code" => 200,
                    "message" => "Product Created",
                    //"product" => $produitCostomBO
                ]);
            }


        } else {
            $response = array(
                "status" => 302,
                "message" => "label exist already !",
            );
            return $response;
        }

    }

    /**
     * @Rest\Post("/produitbo/{id}/update", name="produitbo_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $produit = $this->em->getRepository(Produit::class)->find($id);

        $oldFile = $produit->getFile();
        if (isset($produit)) {
            $produit->setNom($request->request->get('label') ?? $produit->getNom());
            $produit->setIsVisible($request->request->get('is_visible') ?? $produit->getIsVisible());
            $produit->setColor($request->request->get('codeCouleur') ?? $produit->getColor());
            $typeproduit = $this->em->getRepository(TypeProduit::class)->find($request->request->get("type"));
            $produit->setTypeproduit($typeproduit ?? $produit->getTypeproduit());

            if ($request->files->get("path")) {
                $uplodedImage = $request->files->get('path');
                $fileUploader = new  FileUploader($this->getParameter('image_product_directory'));
                $fileName = $fileUploader->upload($uplodedImage);
                $path = '/uploads/product/' . $fileName;
                $file = new File();
                $file->setLabel($fileName);
                $file->setPath($path);
                $this->em->persist($file);
                $this->em->flush();
                $produit->setFile($file);
                $this->em->persist($produit);
                $this->em->flush();
            }

            $this->em->persist($produit);
            $this->em->flush();

            //delete old photo
            if ($request->files->get("path")) {
                $this->em->remove($oldFile);
                $this->em->flush();
            }
            $produitCostomBO = $this->em->getRepository(Produit::class)->findProduitBOById($produit->getId());
            return $this->successResponse([
                "code" => 200,
                "message" => "Product Updated",
                "product" => $produitCostomBO
            ]);
        }
    }

    /**
     * @Rest\Delete("/produitbo/{id}/delete",name="produitbo_delete")
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