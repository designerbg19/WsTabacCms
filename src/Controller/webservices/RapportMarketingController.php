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
class RapportMarketingController extends MainController
{
    /**
     * @Rest\Get("/rapportMarketingGET", name="rapportMarketingGET")
     */
    public function rapportMarketingGet()
    {
        $query = $this->em
            ->createQuery('SELECT   c.id, c.isConcurent,c.nom as label  FROM App\Entity\MarcConcurent c ');
        $Concurent = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT   t.id, t.nom as label  FROM App\Entity\MarkTypeDeCompagne t ');
        $MarkTypeDeCompagne = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT   e.id, e.nom as label  FROM App\Entity\MarkNouvelEquipement e ');
        $MarkNouvelEquipement = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT   p.id, p.nom  as label  FROM App\Entity\PdvTPOSM p ');
        $PdvTPOSM = $query->getResult();
        $rapportMarketingGET = [
            'MarcConcurent' => $Concurent,
            'MarkTypeDeCompagne' => $MarkTypeDeCompagne,
            'MarkNouvelEquipement' => $MarkNouvelEquipement,
            'PdvTPOSM' => $PdvTPOSM
        ];
        // $rapportMarketingGET =new RapportMarketing($Concurent,$MarkTypeDeCompagne,$MarkNouvelEquipement,$PdvTPOSM);
        if (isset($rapportMarketingGET)) {
            return $this->successResponse($rapportMarketingGET);
        }
    }

    /**
     * @Rest\Post("/rapportMarketingPost", name="rapportMarketingPost")
     */
    public function rapportTlpPost(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $rapportMarketings = $content['rapportMarketings'];
        /////////////////////////////////////
        ///
        ///
/*
        $rapportMarketings = Array(
            "0" => Array
            (
                'is_tposm'=>false,
                'is_concurrent' => true,
                'concurrent_id' => 1,
                'type_de_compagne_id' => 1,
                'OneToOne' => true,
                'nouvel_equipment_id' => 1,
                'tposm' => Array(
                    '0' => 4,
                    '1' => 2,
                    '2' => 3,
                ),
            ),
            "1" => Array
            (
                'is_tposm'=>true,
                'is_concurrent' => true,
                'concurrent_id' => 2,
                'type_de_compagne_id' => 2,
                'OneToOne' => true,
                'nouvel_equipment_id' => 2,
                'tposm' => Array(
                    '0' => 1,
                    '1' => 2,
                    '2' => 3,
                ),
            ),
        );
*/
        $id_Rapports=array();

        foreach ((array)$rapportMarketings as $element) {

            $Isconcurrent = $element['is_concurrent'];
            if ($Isconcurrent === true) {
                $concurrent_id = $element['concurrent_id'];
                $type_de_compagne_id = $element['type_de_compagne_id'];
                $nouvel_equipment_id = $element['nouvel_equipment_id'];
                $OneToOne = $element['OneToOne'];
                $is_tposm = $element['is_tposm'];

                $concurent = $this->em->getRepository(MarcConcurent::class)->find($concurrent_id);
                $type_de_compagne = $this->em->getRepository(MarkTypeDeCompagne::class)->find($type_de_compagne_id);
                $nouvel_equipment = $this->em->getRepository(MarkNouvelEquipement::class)->find($nouvel_equipment_id);

                $rapportMarketing = new RapportMarketing();
                $rapportMarketing->addConcurrent($concurent);
                $rapportMarketing->setIsOneToOne($OneToOne);
                $rapportMarketing->setNouvelEquipment($nouvel_equipment);
                $rapportMarketing->setTypeDeCompagnie($type_de_compagne);
                if ($is_tposm === true) {
                    $tposmArray = $element['tposm'];
                    foreach ((array)$tposmArray as $element2) {
                        $tposm_id = $element2;
                        $tposm = $this->em->getRepository(PdvTPOSM::class)->find($tposm_id);
                        $rapportMarketing->addTposm($tposm);
                        $this->em->persist($rapportMarketing);
                        $this->em->flush();
                    }
                }
                $this->em->persist($rapportMarketing);
                $this->em->flush();
                $id_Rapport=$rapportMarketing->getId();
                $id_Rapports[]=$id_Rapport;
            }
        }

        if(isset($content["commentText"])&& !empty($content["commentText"])&& !empty($id_Rapports) ){
            $commentText=$content["commentText"];
            foreach (array($id_Rapports)as $element){
                $commentMark=new Commentaire();
                $id_RapportMArk=$element;
                $commentMark->setText($commentText);
                $CommentaireType = $this->em->getRepository(CommentaireType::class)->find(5);

                $commentMark->setType($CommentaireType);
                $RapportMArk = $this->em->getRepository(RapportMarketing::class)->find($id_RapportMArk);

                $commentMark->addRapportMarketing($RapportMArk);
                $this->em->persist($commentMark);
                $this->em->flush();}
        }


        if (http_response_code(200) == true) {
            return $this->successResponse([
                "code" => 200,
                "message" => "rapport Marketing Created ",
                "id_Marketing_Rapport"=> $id_Rapports
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