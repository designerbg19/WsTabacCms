<?php

namespace App\Controller\webservices;

use App\Entity\Client;
use App\Entity\Commentaire;
use App\Entity\CommentaireType;
use App\Entity\File;
use App\Entity\Produit;
use App\Entity\RapportProduit;
use App\Entity\TypeProduit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class RapportProduitController extends MainController
{
    /**
     * @Rest\Get("/rapportproduit", name="rapportproduit")
     */
    public function rapportproduitGet()
    {
        $produit = $this->em->getRepository(Produit::class)->produit();//produit
        if (isset($produit)) {
            return $this->successResponse($produit);
        }
    }

    /**
     * @Rest\Get("/rapportproduitBO", name="rapportproduitBO")
     */
    public function rapportproduitBOGet()
    {
        $produitNotJti = $this->em->getRepository(Produit::class)->produitBONOtJTI();//produit
        $produitJti = $this->em->getRepository(Produit::class)->produitBOJTI();//produit
        $produit=['produitNotJti'=>$produitNotJti,'produitJti'=>$produitJti];
        if (isset($produit)) {
            return $this->successResponse($produit);
        }
    }

    /**
     * @Rest\Post("/rapportproduitPost", name="rapportproduitPost")
     */
    public function rapportproduitPost(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $rapportProduits = $content['rapportProduits'];
        /////////////////////////////////////
     /*    $rapportProduits = Array(
             "0" => Array
             (
                 'RapportProduit_IsJTI' => true,
                 'RapportProduit_IsDispo' => true,
                 'RapportProduit_Isvender' => true,
                 'Produit_id' => 1,
             ),
             "1" => Array
             (
                 'RapportProduit_IsJTI' => true,
                 'RapportProduit_IsDispo' => true,
                 'RapportProduit_Isvender' => true,
                 'Produit_id' => 4,
             ),
             "2" => Array
             (
                 'RapportProduit_IsJTI' => false,
                 'RapportProduit_IsDispo' => true,
                 'RapportProduit_Isvender' => false,
                 'Produit_id' => 5,
             ),
         );
        */
        $id_Rapports=array();
        foreach ((array)$rapportProduits as $element) {
            //  $Is_JTI_test = $rapportProduits['0']['RapportProduit_IsJTI'];
            $Is_JTI = $element['RapportProduit_IsJTI'];
            $rapportProduit = new RapportProduit();
            $produit_id = $element['Produit_id'];
            $produit = $this->em->getRepository(Produit::class)->find($produit_id);

            if ($Is_JTI === true) {
                $isDispo = $element['RapportProduit_IsDispo'];
                $isVender = $element['RapportProduit_Isvender'];
                $rapportProduit->setIsDispo($isDispo);
                $rapportProduit->setIsVeder($isVender);
                $rapportProduit->addProduit($produit);


            } else {
                $isDispo = $element['RapportProduit_IsDispo'];
                $rapportProduit->setIsDispo($isDispo);
                $rapportProduit->setIsVeder(null);
                $rapportProduit->addProduit($produit);

            }
            $this->em->persist($rapportProduit);
            $this->em->persist($produit);
            $this->em->flush();

            $id_Rapport=$rapportProduit->getId();
            $id_Rapports[]=$id_Rapport;
        }

        if(isset($content["commentText"])&& !empty($content["commentText"])&& !empty($id_Rapports) ){
            $commentText=$content["commentText"];

            foreach (array($id_Rapports)as $element){
                $id_RapportProd=$element;

                $commentProduit=new Commentaire();

                $commentProduit->setText($commentText);
                $CommentaireType = $this->em->getRepository(CommentaireType::class)->find(1);
                $commentProduit->setType($CommentaireType);
                $this->em->persist($commentProduit);
                $this->em->flush();

                $id=$commentProduit->getId();
                $comm = $this->em->getRepository(Commentaire::class)->find($id);

                $Rapport = $this->em->getRepository(RapportProduit::class)->find($id_RapportProd);
                $Rapport->addCommentProduit($comm);
                 $this->em->persist($Rapport);
                $this->em->flush();
                }
              //  $commentProduit->addRapportProduit($Rapport);
        }

        if (http_response_code(200) == true) {
            return $this->successResponse([
                "code" => 200,
                "message" => "rapport Produits Created ",
                "id_Produits_Rapport"=> $id_Rapports
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