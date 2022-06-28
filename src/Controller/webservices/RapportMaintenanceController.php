<?php

namespace App\Controller\webservices;

use App\Entity\Client;
use App\Entity\Commentaire;
use App\Entity\CommentaireType;
use App\Entity\File;
use App\Entity\MarcConcurent;
use App\Entity\MarkNouvelEquipement;
use App\Entity\MarkTypeDeCompagne;
use App\Entity\PdvTPOSM;
use App\Entity\Produit;
use App\Entity\RapportMaintenance;
use App\Entity\RapportMaintListMa;
use App\Entity\RapportMarketing;
use App\Entity\RapportProduit;
use App\Entity\RapportTlp;
use App\Entity\TlpStokeCourant;
use App\Entity\TypeProduit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use app\src\Respons;

/**
 * @Route ("api", name="api_")
 *
 */
class RapportMaintenanceController extends MainController
{
    /**
     * @Rest\Get("/rapportMaintenanceGET", name="rapportMaintenanceGET")
     */
    public function rapportTlpGet()
    {
        $query = $this->em
            ->createQuery('SELECT   c.id, c.diffintion   FROM App\Entity\RapportMaintListMa c ');
        $RapportMaintListMa = $query->getResult();

        if (isset($RapportMaintListMa)) {
            return $this->successResponse($RapportMaintListMa);
        }
    }

    /**
     * @Rest\Post("/rapportMaintenancePost", name="rapportMaintenancePost")
     */
    public function rapportTlpPost(Request $request)
    {
         $content = json_decode($request->getContent(), true);
        $rapportMaintenance = $content['rapportMaintenance'];
        /////////////////////////////////////
        ///
        ///
        ///
/*
        $rapportMaintenance = Array(
            "0" => Array
            (
                'is_Maintenence' => true,
                'diff_id' => 1,
                'Explication' => 'KDM n est pas seulement unsite E-commerce. Nous attachons une grande importance à ce ',

            ),
            "1" => Array
            (
                'is_Maintenence' => false,
                'diff_id' => 1,
                'Explication' => 'KDM n est pas seulement unsite E-commerce. Nous attachons une grande importance à ce ',

            ),

        );
*/
        $id_Rapports=array();

        foreach ((array)$rapportMaintenance as $element) {
            $is_Maintenence = $element['is_Maintenence'];
            if ($is_Maintenence === true) {
                $diff_id = $element['diff_id'];
                $Explication = $element['Explication'];
                $diff = $this->em->getRepository(RapportMaintListMa::class)->find($diff_id);

                $rapportMaintenance = new RapportMaintenance();
                $rapportMaintenance->setExplication($Explication);
                $rapportMaintenance->setIsMaintenance(true);
                $rapportMaintenance->addDiffinitionMa($diff);

                $this->em->persist($rapportMaintenance);
                $this->em->flush();
                $id_Rapport=$rapportMaintenance->getId();
                $id_Rapports[]=$id_Rapport;
            }
        }

        if(isset($content["commentText"])&& !empty($content["commentText"])&& !empty($id_Rapports) ){
            $commentText=$content["commentText"];
            foreach (array($id_Rapports)as $element){
                $commentMain=new Commentaire();
                $id_RapportMA=$element;
                $commentMain->setText($commentText);
                $CommentaireType = $this->em->getRepository(CommentaireType::class)->find(6);

                $commentMain->setType($CommentaireType);
                $RapportMA = $this->em->getRepository(RapportMaintenance::class)->find($id_RapportMA);

                $commentMain->addRapportMaintenance($RapportMA);
                $this->em->persist($commentMain);
                $this->em->flush();}
        }

        if (http_response_code(200) == true) {
            return $this->successResponse([
                "code" => 200,
                "message" => "rapport Maintenance Created ",
                "id_Maintenance_Rapport"=> $id_Rapports
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