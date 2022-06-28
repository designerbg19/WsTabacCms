<?php
namespace App\Controller\webservices;

use App\Entity\Client;
use App\Entity\Merch;
use App\Entity\RapportGlobal;
use App\Entity\RapportMaintenance;
use App\Entity\RapportMarketing;
use App\Entity\RapportPPOSM;
use App\Entity\RapportProduit;
use App\Entity\RapportTlp;
use App\Entity\RapportTposm;
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
class RapportGlobalController extends MainController
{
    /**
     * @Rest\Post("/RapportGlobal", name = "RapportGlobal")
     * @param Request $request
     * @return Response
     */
    public function RapportGlobal( Request $request)
    {
        $content = json_decode($request->getContent(), true);
       // $RapportGlobalArray = $content['RapportGlobalArray'];
        $RapportGlobal = new RapportGlobal();
       /* $RapportGlobalArray = Array(
            'idMerch' => 1,
            'repportTime' => "4min 3s",
            'idPDVRapport' => 22,
            'id_PPOSM_Rapport' => 7,
            'id_TLP_Rapport' => 6,
            'id_TPOSM_Rapport' =>1,
            "id_Maintenance_Rapport" => Array
            (
                8,
                9
            ),
            "id_Marketing_Rapport" => Array
            (
                32,
                33
            ),
            "id_Produits_Rapport" => Array
            (
                113,
                114,
                115
            ),
        );
        /*
        Object { "idMerch": 1,
        "idPDVRapport": 272,
        "id_Maintenance_Rapport": Array []
        , "id_Marketing_Rapport": Array []
        , "id_PPOSM_Rapport": 87
        , "id_Produits_Rapport": Array [ 89, 90, 91, 92, 93, 94, 95, ]
        , "id_TLP_Rapport": 17,
        "id_TPOSM_Rapport": Array [ 139, 140, 141, 142, ]
        , "repportTime": "4min 3s", }
        */

       // $repportTime =$RapportGlobalArray['repportTime'];
        $repportTime =$content['repportTime'];
        $RapportGlobal->setDurre($repportTime);
        //$date = \DateTime::createFromFormat('Ymd', '20170101');
       // $dateNow=strlen($dateNow);
       $RapportGlobal->setDateRappoort((new \DateTime()));
        $idMerch =$content['idMerch'];
        $Merch = $this->em->getRepository(Merch::class)->find($idMerch);
        $RapportGlobal->setMerch($Merch);

        $idPDVRapport_id =$content['idPDVRapport'];
        $PDVRapport = $this->em->getRepository(Client::class)->find($idPDVRapport_id);
        $RapportGlobal->setRapportPdv($PDVRapport);


        if(isset($content['id_Maintenance_Rapport']) && !empty($content['id_Maintenance_Rapport'])){
            $id_Maintenance_Rapport=$content['id_Maintenance_Rapport'];
            foreach ((array)$id_Maintenance_Rapport as $element) {
                $Maintenance_Rapport = $this->em->getRepository(RapportMaintenance::class)->find($element);
                $RapportGlobal->addRapportMaintenance($Maintenance_Rapport);
            }
        }


        if (isset($content['id_Marketing_Rapport']) && !empty($content['id_Marketing_Rapport'])){
            $id_Marketing_Rapport=$content['id_Marketing_Rapport'];
            foreach ((array)$id_Marketing_Rapport as $element) {
                $Marketing_Rapport = $this->em->getRepository(RapportMarketing::class)->find($element);
                $RapportGlobal->addRapportMarketing($Marketing_Rapport);
            }
        }

        $id_PPOSM_Rapport=$content['id_PPOSM_Rapport'];
        $PPOSM_Rapport = $this->em->getRepository(RapportPPOSM::class)->find($id_PPOSM_Rapport);
        $RapportGlobal->setRapportPPOSM($PPOSM_Rapport);

        if(isset($content['id_Produits_Rapport']) && !empty($content['id_Produits_Rapport'])) {
            $id_Produits_Rapport = $content['id_Produits_Rapport'];
            foreach ((array)$id_Produits_Rapport as $element) {
                $Produits_Rapport = $this->em->getRepository(RapportProduit::class)->find($element);
                $RapportGlobal->addRapportProduit($Produits_Rapport);
            }
        }

        if(isset($content['id_TLP_Rapport']) && !empty($content['id_TLP_Rapport'])){
            $id_TLP_Rapport=$content['id_TLP_Rapport'];
            $TLP_Rapport = $this->em->getRepository(RapportTlp::class)->find($id_TLP_Rapport);
            $RapportGlobal->setRapportTlp($TLP_Rapport);
        }else{
            $RapportGlobal->setRapportTlp(null);
        }


        if (isset($content['id_TPOSM_Rapport']) && !empty($content['id_TPOSM_Rapport'])) {
            $id_TPOSM_Rapport = $content['id_TPOSM_Rapport'];
            foreach ((array)$id_TPOSM_Rapport as $element) {
                $TPOSM_Rapport = $this->em->getRepository(RapportTposm::class)->find($element);
                $RapportGlobal->setRapportTPOSM($TPOSM_Rapport);
            }
        }





        $this->em->persist($RapportGlobal);
        $this->em->flush();
        if (http_response_code(200) == true) {
            return $this->successResponse([
                "code" => 200,
                "message" => "rapport Global Created "
            ]);
        } else {
            if (http_response_code(500) == true) {
                return $this->successResponse(["message" => "erreur interne du serveur"]);
            } else {
                return $this->successResponse([http_response_code()]);
            }
        }

    }

//return true;
}
