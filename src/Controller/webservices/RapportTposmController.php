<?php

namespace App\Controller\webservices;

use App\Entity\Client;
use App\Entity\Commentaire;
use App\Entity\CommentaireType;
use App\Entity\File;
use App\Entity\PdvTPOSM;
use App\Entity\Produit;
use App\Entity\RapportProduit;
use App\Entity\RapportTposm;
use App\Entity\TposmInstalationNbr;
use App\Entity\TposmPresenceNbr;
use App\Entity\TposmRaisonRefus;
use App\Entity\TypeProduit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class RapportTposmController extends MainController
{
    /**
     * @Rest\Get("/rapporttposm", name="rapporttposm")
     */
    public function rapporttposmGet()
    {
        $pdvTPOSM = $this->em->getRepository(PdvTPOSM::class)->tposm();
        $pdvTPOSMRaison = $this->em->getRepository(TposmRaisonRefus::class)->raison();
        $pdvTPOSMNbrPrésence = $this->em->getRepository(TposmPresenceNbr::class)->nbr();
        $pdvTPOSMNbrInstall = $this->em->getRepository(TposmInstalationNbr::class)->inst();
        $rapporttposmGet = [
            'Tposm' => $pdvTPOSM,
            'Raison' => $pdvTPOSMRaison,
            'nbrPresence' => $pdvTPOSMNbrPrésence,
            'nbrInstall' => $pdvTPOSMNbrInstall
        ];
        if (isset($rapporttposmGet)) {
            return $this->successResponse($rapporttposmGet);
        }
    }

    /**
     * @Rest\Post("/rapporttposmPost", name="rapporttposmPost")
     */
    public function rapporttposmPost(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $rapportTposm = $content['rapportTposm'];
        /////////////////////////////////////
       /*  $rapportTposm = Array(
             "0" => Array
             (
                 'RapportTposm_IsPresent' => true,
                 'RapportTposm_NbrPresenceID' => 1,
                 'RapportProduit_IsInstall' => true,
                 'RapportTposm_NbrInstallID' => 1,
                 'RapportTposm_RaisonID' => null,
             ),
             "1" => Array
             (
                 'RapportTposm_IsPresent' => false,
                 'RapportTposm_NbrPresenceID' => null,
                 'RapportProduit_IsInstall' => false,
                 'RapportTposm_NbrInstallID' => null,
                 'RapportTposm_RaisonID' => 2,
             ),
             "2" => Array
             (
                 'RapportTposm_IsPresent' => false,
                 'RapportTposm_NbrPresenceID' => null,
                 'RapportProduit_IsInstall' => true,
                 'RapportTposm_NbrInstallID' => 3,
                 'RapportTposm_RaisonID' => null,
             ),

         );*/
        $id_Rapports=array();
        foreach ((array)$rapportTposm as $element) {
            $IsPresent = $element['RapportTposm_IsPresent'];
            $IsInstall = $element['RapportProduit_IsInstall'];

            if ($IsInstall == true & $IsPresent == true) {
                $NewRapportTposm = new RapportTposm();
                //Present
                $NewRapportTposm->setIsPresent(true);
                $NbrPresenceID = $element['RapportTposm_NbrPresenceID'];
                $NbrPresence = $this->em->getRepository(TposmPresenceNbr::class)->find($NbrPresenceID);
                $NewRapportTposm->setPresenceNbrArticle($NbrPresence);
                //Install
                $NewRapportTposm->setIsInstall(true);
                $NbrInstallID = $element['RapportTposm_NbrInstallID'];
                $NbrInstall = $this->em->getRepository(TposmInstalationNbr::class)->find($NbrInstallID);
                $NewRapportTposm->setInstallationNbr($NbrInstall);

                $NewRapportTposm->setInstalationRaison(null);

                $this->em->persist($NewRapportTposm);
                $this->em->flush();

            } elseif ($IsInstall == true & $IsPresent == false) {
                $NewRapportTposm = new RapportTposm();

                //Present
                $NewRapportTposm->setIsPresent(false);
                $NewRapportTposm->setPresenceNbrArticle(null);
                //Install
                $NewRapportTposm->setIsInstall(true);
                $NbrInstallID = $element['RapportTposm_NbrInstallID'];
                $NbrInstall = $this->em->getRepository(TposmInstalationNbr::class)->find($NbrInstallID);
                $NewRapportTposm->setInstallationNbr($NbrInstall);

                $NewRapportTposm->setInstalationRaison(null);

                $this->em->persist($NewRapportTposm);
                $this->em->flush();

            } elseif ($IsInstall == false & $IsPresent == true) {
                $NewRapportTposm = new RapportTposm();
                //Present
                $NewRapportTposm->setIsPresent(true);
                $NbrPresenceID = $element['RapportTposm_NbrPresenceID'];
                $NbrPresence = $this->em->getRepository(TposmPresenceNbr::class)->find($NbrPresenceID);
                $NewRapportTposm->setPresenceNbrArticle($NbrPresence);

                //Install
                $NewRapportTposm->setIsInstall(false);
                $RaisonID = $element['RapportTposm_RaisonID'];
                $Raison = $this->em->getRepository(TposmRaisonRefus::class)->find($RaisonID);
                $NewRapportTposm->setInstalationRaison($Raison);
                $NewRapportTposm->setInstallationNbr(null);

                $this->em->persist($NewRapportTposm);
                $this->em->flush();

            } elseif ($IsInstall == false & $IsPresent == false) {
                $NewRapportTposm = new RapportTposm();

                //Present
                $NewRapportTposm->setIsPresent(false);
                $NewRapportTposm->setPresenceNbrArticle(null);
                //Install
                $NewRapportTposm->setIsInstall(false);
                $RaisonID = $element['RapportTposm_RaisonID'];
                $Raison = $this->em->getRepository(TposmRaisonRefus::class)->find($RaisonID);
                $NewRapportTposm->setInstalationRaison($Raison);
                $NewRapportTposm->setInstallationNbr(null);

                $this->em->persist($NewRapportTposm);
                $this->em->flush();
                $id_Rapport=$NewRapportTposm->getId();
                $id_Rapports[]=$id_Rapport;
            }
        }

        if(isset($content["commentText"])&& !empty($content["commentText"])&& !empty($id_Rapports) ){
            $commentText=$content["commentText"];
            foreach (array($id_Rapports)as $element){
                $commentTPOSM=new Commentaire();
                $id_RapportTPOSM=$element;
                $commentTPOSM->setText($commentText);
                $CommentaireType = $this->em->getRepository(CommentaireType::class)->find(3);
                $commentTPOSM->setType($CommentaireType);

                $RapportTPOSM = $this->em->getRepository(RapportTposm::class)->find($id_RapportTPOSM);

                $commentTPOSM->addRapportTposm($RapportTPOSM);
            $this->em->persist($commentTPOSM);
            $this->em->flush();}
        }

        if (http_response_code(200) == true) {
            return $this->successResponse([
                "code" => 200,
                "id_TPOSM_Rapport" => $id_Rapports,
                "message" => "rapport TPOSM Created "
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
