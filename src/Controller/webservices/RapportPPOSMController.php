<?php

namespace App\Controller\webservices;

use App\Entity\Client;
use App\Entity\Commentaire;
use App\Entity\CommentaireType;
use App\Entity\DesinstallationPresentoireNotJti;
use App\Entity\DesInstallPresentoireJti;
use App\Entity\File;
use App\Entity\InfoClient;
use App\Entity\InstallPresentoireJti;
use App\Entity\MarketingRecette;
use App\Entity\Merch;
use App\Entity\PdvPPSOM;
use App\Entity\PdvPresentoire;
use App\Entity\PdvShop;
use App\Entity\PlvTemporaire;
use App\Entity\PresencePpsomJti;
use App\Entity\PresencePresentoireJti;
use App\Entity\PresencePresentoireNotJti;
use App\Entity\PresenceShopJti;
use App\Entity\QuantiterTypePlv;
use App\Entity\RaisonPresontoire;
use App\Entity\RapportPPOSM;
use App\Entity\TypePlv;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class RapportPPOSMController extends MainController
{

    /**
     * @Rest\Get("/RapportPPOSM", name="RapportPPOSM_get")
     * @return Response\
     */
    public function showinfoPPOSM()
    {
        $PdvPresentoire_jti = $this->em->getRepository(PdvPresentoire::class)->findprsentoireJti();
        $raison = $this->em->getRepository(RaisonPresontoire::class)->raison();
        $PdvPPSOM = $this->em->getRepository(PdvPPSOM::class)->pposm();
        $PdvShop = $this->em->getRepository(PdvShop::class)->shop();
        $PdvPresentoire_Notjti = $this->em->getRepository(PdvPresentoire::class)->findprsentoireNotJti();
        $QuantiterTypePlv = $this->em->getRepository(QuantiterTypePlv::class)->quantiter();
        $TypePlv = $this->em->getRepository(TypePlv::class)->type();
        
        $PPOSM = [
            'Presentoire' => $PdvPresentoire_jti,
            'raisonPresence' => $raison,
            'PPSOM' => $PdvPPSOM,
            'shop' => $PdvShop,
            'Presentoire_Notjti' => $PdvPresentoire_Notjti,
            'QuantiterTypePlv' => $QuantiterTypePlv,
            'TypePlv' => $TypePlv,
        ];
        return $this->successResponse($PPOSM);

    }

    /**
     * RapportPPOSMFunction
     * @Rest\Post("/RapportPPOSM/{idClient}", name = "RapportPPOSM")
     *
     * @return Response
     */
    public function registerPposmRapport(Request $request, int $idClient)
    {
        $rapportPPOSM = new RapportPPOSM();
        //test phase
        //live it to the end
        $client = $this->em->getRepository(Client::class)->find($idClient);
        $rapportPPOSM->setClient($client);
        $rapportPPOSM->setDateRapport(new \DateTime());
        /* $this->em->persist($rapportPPOSM);
         $this->em->flush();
         return $this->successResponse($rapportPPOSM);
         die();*/


        //1 done

        $InstallPresentoireJti = $this->installPresentoireJti($request);
        $rapportPPOSM->setInstallPresentoireJti($InstallPresentoireJti);

        //2 DONE
        $Des_InstallPresentoireJti = $this->desIntallPresentoireJti($request);
        $rapportPPOSM->setDesInstallPresentoireJti($Des_InstallPresentoireJti);

        //3 DONE
        $presencePresentoire = $this->présencePrésentoireJTI($request);
        $rapportPPOSM->setPresencePresentoireJti($presencePresentoire);

        //4
        $content = json_decode($request->getContent(), true);
        $infopresencePPSOM = $content['infopresencePPSOM'];
        /////////////////////////////////////////////////////////////////////////
        /* $infopresencePPSOM = Array(
             "0" => Array
             (
                 'PPSOMPresence_IsPresent' => false,
                 'PPSOMPresence_Quantiter' => 987,
                 'PdvPpsom_id' => 4,
             ),
             "1" => Array
             (
                 'PPSOMPresence_IsPresent' => true,
                 'PPSOMPresence_Quantiter' => 654,
                 'PdvPpsom_id' => 3,
             ),
             "2" => Array
             (
                 'PPSOMPresence_IsPresent' => true,
                 'PPSOMPresence_Quantiter' => 1123,
                 'PdvPpsom_id' => 2,
             ),
         );*/
        /////////////////////////////////////////////////////////////////////////

        foreach ((array)$infopresencePPSOM as $element) {
            $Is_PPSOMPresent_test = $infopresencePPSOM['0']['PPSOMPresence_IsPresent'];
            $Is_PPSOMPresent = $element['PPSOMPresence_IsPresent'];
            if ($Is_PPSOMPresent_test === true) {
                $presencePPSOM = new PresencePpsomJti();
                $Quantiter = $element['PPSOMPresence_Quantiter'];
                $PdvPpsom_id = $element['PdvPpsom_id'];
                $presencePPSOM->setIsPresent($Is_PPSOMPresent);
                $presencePPSOM->setQuantiter($Quantiter);
                $PPSOM = $this->em->getRepository(PdvPPSOM::class)->find($PdvPpsom_id);
                $presencePPSOM->addPdvPpsom($PPSOM);
                $this->em->persist($presencePPSOM);
                $this->em->flush();

            } else {
                $presencePPSOM = new PresencePpsomJti();
                $presencePPSOM->setIsPresent(false);
                $presencePPSOM->setQuantiter(null);
            }
            $this->em->persist($presencePPSOM);
            $this->em->flush();
            $rapportPPOSM->addPresencePpsomJt($presencePPSOM);
        }


        //5 Présence Shop programes
        $content = json_decode($request->getContent(), true);
        $infopresenceShop = $content['infopresenceShop'];
        /*
                /////////////////////////////////////
                 $infopresenceShop = Array(
                      "0" => Array
                      (
                          'ShopPresence_IsPresent' => true,
                          'SHOPPresence_Quantiter' => 987,
                          'SHOP_id' => 1,
                      ),
                      "1" => Array
                      (
                          'ShopPresence_IsPresent' => true,
                          'SHOPPresence_Quantiter' => 654,
                          'SHOP_id' => 2,
                      ),

                  );*/

        foreach ((array)$infopresenceShop as $element) {
            $Is_Shopresent_test = $infopresenceShop['0']['ShopPresence_IsPresent'];
            $Is_ShopPresent = $element['ShopPresence_IsPresent'];
            if ($Is_Shopresent_test === true) {
                $presenceShop = new PresenceShopJti();
                $Quantiter = $element['SHOPPresence_Quantiter'];
                $PdvShop_id = $element['SHOP_id'];
                $presenceShop->setIsPresent($Is_ShopPresent);
                $presenceShop->setQuantiter($Quantiter);
                $SHOP = $this->em->getRepository(PdvShop::class)->find($PdvShop_id);
                $presenceShop->addPdvshop($SHOP);
                $this->em->persist($presenceShop);
                $this->em->flush();

            } else {
                $presenceShop = new PresenceShopJti();
                $presenceShop->setIsPresent(false);
                $presenceShop->setQuantiter(null);
            }
            $this->em->persist($presenceShop);
            $this->em->flush();
            $rapportPPOSM->addPresenceShopJti($presenceShop);
        }
        //************CONCURENCE *************************

        //6 Présece Presentoire CONCU
        $content = json_decode($request->getContent(), true);
        $infopresencePresentoireNotJti = $content['infopresencePresentoireNotJti'];
        //======================================================================
        /*
                 $infopresencePresentoireNotJti = Array(
                     "0" => Array
                     (
                         'PresencePresentoire_NotJti_IsPresent' => true,
                         'PresentoirePresenceNotJti_Quantiter' => 987,
                         'PresencePresentoireNotJti_id_presentoireInstall' => 19,
                     ),
                     "1" => Array
                     (
                         'PresencePresentoire_NotJti_IsPresent' => true,
                         'PresentoirePresenceNotJti_Quantiter' => 654,
                         'PresencePresentoireNotJti_id_presentoireInstall' => 20,
                     ),

                 );
         */
        foreach ((array)$infopresencePresentoireNotJti as $element) {
            $Is_present_test = $infopresencePresentoireNotJti['0']['PresencePresentoire_NotJti_IsPresent'];
            $Is_Present = $element['PresencePresentoire_NotJti_IsPresent'];
            if ($Is_present_test === true) {
                $presenceNotJTI = new PresencePresentoireNotJti();
                $Quantiter = $element['PresentoirePresenceNotJti_Quantiter'];
                $Presentoire_id = $element['PresencePresentoireNotJti_id_presentoireInstall'];
                $presenceNotJTI->setIsPresent($Is_Present);
                $presenceNotJTI->setQuantiter($Quantiter);
                $PresentoireNotJti = $this->em->getRepository(PdvPresentoire::class)->find($Presentoire_id);
                $presenceNotJTI->addPdvPresentoire($PresentoireNotJti);
                $this->em->persist($presenceNotJTI);
                $this->em->flush();

            } else {
                $presenceNotJTI = new PresencePresentoireNotJti();
                $presenceNotJTI->setIsPresent(false);
                $presenceNotJTI->setQuantiter(null);
            }
            $this->em->persist($presenceNotJTI);
            $this->em->flush();
            $rapportPPOSM->addPresencePresentoireNotJti($presenceNotJTI);
        }

        ////////////////////////////////////////////////////////////////
        //7 PLV Temporaire

        $content = json_decode($request->getContent(), true);
        $PLVTemporaireNotJti = $content['PLVTemporaireNotJti'];
        /*
                    $PLVTemporaireNotJti = Array(
                        "0" => Array
                        (
                            'PlvTemporaire_IsTemporaire' => true,
                            'PresencePresentoire_NotJti_quantiterId' => 2,
                            'type_Plv_Temporaire_id' => 1,
                        ),
                        "1" => Array
                        (
                            'PresencePresentoire_NotJti_IsPresent' => true,
                            'PresencePresentoire_NotJti_quantiterId' => 5,
                            'type_Plv_Temporaire_id' => 2,
                        ),
                        "2" => Array
                        (
                            'PresencePresentoire_NotJti_IsPresent' => true,
                            'PresencePresentoire_NotJti_quantiterId' => 4,
                            'type_Plv_Temporaire_id' => 3,
                        ),

                    );
       */
        foreach ((array)$PLVTemporaireNotJti as $element) {
            $plvTemporaire = new PlvTemporaire();
            $PLVTemporaire_test = $PLVTemporaireNotJti['0']['PlvTemporaire_IsTemporaire'];
            if ($PLVTemporaire_test == true) {
                $notJti_quantiterId = $element['PresencePresentoire_NotJti_quantiterId'];
                $quantiterId = $this->em->getRepository(QuantiterTypePlv::class)->find($notJti_quantiterId);
                $plvTemporaire->setIsTemporaire($PLVTemporaire_test);
                $plvTemporaire->setQuantiterTypePlv($quantiterId);
                $type_Plv_id = $element['type_Plv_Temporaire_id'];
                $typePlv = $this->em->getRepository(TypePlv::class)->find($type_Plv_id);
                $plvTemporaire->addTypePlv($typePlv);

                // $this->em->persist($plvTemporaire);
                // $this->em->flush();
            } else {
                $plvTemporaire->setIsTemporaire(false);
            }
            $rapportPPOSM->addPlvTemporaire($plvTemporaire);
            $this->em->persist($plvTemporaire);
            $this->em->flush();

        }

        //8 Desinstall presentoire Not JTI
        $content = json_decode($request->getContent(), true);
        $infoDesintall = $content['infoDesintall'];
        /*
        $infoDesintall = Array(
            "0" => Array
            (
                'IsDesinstall' => true,
                'Presentoire_Quantiter' => 987,
                'Presentoire_id' => 20,
            ),
            "1" => Array
            (
                'IsDesinstall' => true,
                'Presentoire_Quantiter' => 100,
                'Presentoire_id' => 19,
            ),
            "2" => Array
            (
                'IsDesinstall' => true,
                'Presentoire_Quantiter' => 200,
                'Presentoire_id' => 18,
            ),
        );*/
        /////////////////////////////////////////////////////////////////////////

        foreach ((array)$infoDesintall as $element) {
            $Desinstall_test = $infoDesintall['0']['IsDesinstall'];
            $Is_Desinstall = $element['IsDesinstall'];
            if ($Desinstall_test === true) {
                $presentoireDesinstall = new DesinstallationPresentoireNotJti();
                $Quantiter = $element['Presentoire_Quantiter'];
                $PdvPpsom_id = $element['Presentoire_id'];
                $presentoireDesinstall->setIsDesinstall($Is_Desinstall);
                $presentoireDesinstall->setQuantiter($Quantiter);
                $Presentoire = $this->em->getRepository(PdvPresentoire::class)->find($PdvPpsom_id);
                $presentoireDesinstall->addPdvPresentoire($Presentoire);
                $this->em->persist($presentoireDesinstall);
                $this->em->flush();

            } else {
                $presentoireDesinstall = new DesinstallationPresentoireNotJti();
                $presentoireDesinstall->setIsDesinstall(false);
                $presentoireDesinstall->setQuantiter(null);
            }
            $this->em->persist($presentoireDesinstall);
            $this->em->flush();
            $rapportPPOSM->addDesIntallPresentoireNotJti($presentoireDesinstall);
        }


        /// ***************************************************************

        //setting Data
        $this->em->persist($rapportPPOSM);
        $this->em->flush();
        $id_RapportPPOSM=$rapportPPOSM->getId();

        if(isset($content["commentText"])&& !empty($content["commentText"]) ){
        $commentPPOSM=new Commentaire();
        $commentText=$content["commentText"];
        $commentPPOSM->setText($commentText);
        $CommentaireType = $this->em->getRepository(CommentaireType::class)->find(2);
        $commentPPOSM->setType($CommentaireType);
       // $commentPPOSM->setRapportPPOSM($id_RapportPPOSM);
        $this->em->persist($commentPPOSM);
        $this->em->flush();
        $id=$commentPPOSM->getId();
        $commmt = $this->em->getRepository(Commentaire::class)->find($id);
        $RapportPPOSM = $this->em->getRepository(RapportPPOSM::class)->find($id_RapportPPOSM);
        $RapportPPOSM->addCommentPPOSM($commmt);

        $this->em->persist($RapportPPOSM);
        $this->em->flush();}
        if (http_response_code(200) == true) {
            return $this->successResponse([
                "code" => 200,
                "id_PPOSM_Rapport" => $id_RapportPPOSM,
                "message" => "rapport Pdv Created "
            ]);
        } else {
            if (http_response_code(500) == true) {
                return $this->successResponse(["message" => "erreur interne du serveur"]);
            } else {
                return $this->successResponse([http_response_code()]);
            }
        }
    }

    public function installPresentoireJti(Request $request)
    {
        $InstallPresentoireJti = new InstallPresentoireJti();
        $is_installation = $request->request->get("InstallPresentoireJti_IsInstallation");
        if ($is_installation == true) {
            $InstallPresentoireJti->setIsInstallation($is_installation);
            $InstallPresentoireJti->setQuantiter($request->request->get("InstallPresentoireJti_Quantiter"));
            $idPresentoire = $request->request->get("InstallPresentoireJti_id_presentoireInstall");
            $presentoireInstall = $this->em->getRepository(PdvPresentoire::class)->find($idPresentoire);
            $InstallPresentoireJti->setPresentoire($presentoireInstall);
        } else {
            $InstallPresentoireJti->setIsInstallation($is_installation);
            $InstallPresentoireJti->setQuantiter(null);
            $InstallPresentoireJti->setPresentoire(null);
        }
        $this->em->persist($InstallPresentoireJti);
        $this->em->flush();
        return $InstallPresentoireJti;
    }

    public function desIntallPresentoireJti(Request $request)
    {
        $Des_InstallPresentoireJti = new DesInstallPresentoireJti();
        $Des_is_installation = $request->request->get("DesinstallPresentoireJti_IsInstallation");
        if ($Des_is_installation == true) {
            $Des_InstallPresentoireJti->setIsDesinstall($Des_is_installation);
            $Des_InstallPresentoireJti->setQuantiter($request->request->get("DesinstallPresentoireJti_Quantiter"));
            $presentoireDesinstall = $this->em->getRepository(PdvPresentoire::class)->find($request->request->get("DesinstallPresentoireJti_id_presentoireInstall"));
            $Des_InstallPresentoireJti->setPresentoire($presentoireDesinstall);
        } else {
            $Des_InstallPresentoireJti->setIsDesinstall($Des_is_installation);
            $Des_InstallPresentoireJti->setQuantiter(null);
            $Des_InstallPresentoireJti->setPresentoire(null);
        }
        $this->em->persist($Des_InstallPresentoireJti);
        $this->em->flush();
        return $Des_InstallPresentoireJti;
    }

    public function présencePrésentoireJTI(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $presencePresentoire = new PresencePresentoireJti();
        $Is_present = $request->request->get("PresencePresentoireJti_IsPresent");
        if ($Is_present == true) {
            $presencePresentoire->setIsPresent($Is_present);
            $presencePresentoire->setQuantiter($request->request->get("PresencePresentoireJti_Quantiter"));
            $presentoirePresence = $this->em->getRepository(PdvPresentoire::class)->find($request->request->get("PresencePresentoireJti_id_presentoireInstall"));
            $presencePresentoire->setPdvPresentoire($presentoirePresence);
        } else {
            $Raison_PresencePresentoireJti = $content['Raison_PresencePresentoireJti_id'];
            $presencePresentoire->setIsPresent($Is_present);

            foreach ((array)$Raison_PresencePresentoireJti as $element) {
                $Raison_PresencePresentoireJti_id = $element['Raison_PresencePresentoireJti_id'];
                if (is_int($Raison_PresencePresentoireJti_id)) {
                    $raisonPresentoire = $this->em->getRepository(RaisonPresontoire::class)->find($Raison_PresencePresentoireJti_id);
                    $presencePresentoire->addRaison($raisonPresentoire);
                }else{
                    $presencePresentoire->setAutreRaison($Raison_PresencePresentoireJti_id);
                }
            }

        }
        $this->em->persist($presencePresentoire);
        $this->em->flush();
        return $presencePresentoire;
    }


}