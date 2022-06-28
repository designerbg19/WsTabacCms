<?php

namespace App\Controller\webservices;

use App\Entity\Client;
use App\Entity\Commentaire;
use App\Entity\CommentaireType;
use App\Entity\File;
use App\Entity\Produit;
use App\Entity\RapportProduit;
use App\Entity\RapportTlp;
use App\Entity\TlpStokeCourant;
use App\Entity\TypeProduit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class RapportTlpController extends MainController
{
    /**
     * @Rest\Get("/rapportTlp", name="rapportTlp")
     */
    public function rapportTlpGet()
    {
        /* $query = $this->em
             ->createQuery('SELECT   u.id, u.nom  FROM App\Entity\Produit u ');
         $produit = $query->getResult();*/
        $produit = $this->em->getRepository(Produit::class)->produitBOJTI();

        if (isset($produit)) {
            return $this->successResponse($produit);
        }
    }

    /**
     * @Rest\Post("/rapportTlpPost", name="rapportTlpPost")
     */
    public function rapportTlpPost(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $rapportTlp = $content['rapportTlp'];

        $rapportTlpProduit = $rapportTlp['rapportTlpProduit'];
        //  if (isset($rapportTlp) || isset($rapportTlpProduit)) {
        $IsPlanogramme = $rapportTlp['RapportTlp_IsPlanogramme'];
        $IsEclairage = $rapportTlp['RapportTlp_IsEclairage'];
        $rapporTlps = new RapportTlp();
        $rapporTlps->setIsPlanogramme($IsPlanogramme);
        $rapporTlps->setIsEclairage($IsEclairage);
        //$id_Rapports=array();

        foreach ((array)$rapportTlpProduit as $element) {
            //  if (is_numeric($key)) {
            $produitID = $element['id_produit'];
            $quantiterProduit = $element['tlp_produit'];
            $tlpstokceCourant = new TlpStokeCourant();
            $produit = $this->em->getRepository(Produit::class)->find($produitID);
            $tlpstokceCourant->setQuantiter($quantiterProduit);
            if (isset($produit)) {
                $tlpstokceCourant->addProduit($produit);
            }
            $rapporTlps->addStockeCourant($tlpstokceCourant);
            $this->em->persist($tlpstokceCourant);

            $this->em->persist($rapporTlps);
            $this->em->flush();
            $id_Rapport=$rapporTlps->getId();


          //  $id_Rapports[]=$id_Rapport;
        }
        if(isset($content["commentText"])&& !empty($content["commentText"]) ){
        $commentTLP=new Commentaire();
        $commentText=$content["commentText"];
        $commentTLP->setText($commentText);
            $CommentaireType = $this->em->getRepository(CommentaireType::class)->find(4);

            $commentTLP->setType($CommentaireType);
        $commentTLP->setRapportTlp($id_Rapport);
        $this->em->persist($commentTLP);
        $this->em->flush();}

        if (http_response_code(200) == true) {
            return $this->successResponse([
                "code" => 200,
                "message" => "rapport TLP Created ",
                "id_TLP_Rapport"=> $id_Rapport
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
