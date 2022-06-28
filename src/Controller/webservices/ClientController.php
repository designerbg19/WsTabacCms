<?php

namespace App\Controller\webservices;

use App\Entity\Age;
use App\Entity\Client;
use App\Entity\ClientDraft;
use App\Entity\Commentaire;
use App\Entity\CommentaireType;
use App\Entity\Deligation;
use App\Entity\File;
use App\Entity\Gouvernorat;
use App\Entity\InfDecideur;
use App\Entity\InfoClient;
use App\Entity\MarketingCampagneEnCours;
use App\Entity\MarketingRecette;
use App\Entity\MarketingRegieTabac;
use App\Entity\NbrEmployer;
use App\Entity\NbrEnfant;
use App\Entity\PdvClasses;
use App\Entity\PdvEmplacements;
use App\Entity\PdvEnvironnements;
use App\Entity\PdvPresentoire;
use App\Entity\PdvSuperficie;
use App\Entity\PdvTypesQuartier;
use App\Entity\PdvTypologies;
use App\Entity\PdvVisibilite;
use App\Entity\Produit;
use App\Entity\Quartier;
use App\Entity\Region;
use App\Entity\Routing;
use App\Entity\SituationFamilialle;
use App\Entity\Stoke;
use App\Entity\StokeContainer;
use App\Entity\StokeSheet;
use App\Entity\TypeClient;
use App\Entity\Zone;
use App\Service\FileUploader;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializerBuilder;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class ClientController extends MainController
{
    /**
     * @Rest\Get("/client/{id}", name="client_show_info_by_PDV_id")
     * @return Response\
     */
    public function showinfoPDV(int $id)
    {
        $client = $this->em->getRepository(Client::class)->find($id);
        $stokeMin = $this->em->getRepository(Client::class)->findClientsStoke($client);dump($stokeMin);die();

      //  $stokeMin = $this->em->getRepository(Client::class)->stokeMin($id);dump($stokeMin);die();
        $recetteP_id = $client->getRecetteP();
        $recetteS_id = $client->getRecetteS();
        $clientInfo = $this->em->getRepository(Client::class)->findClientInfo($id);
        $clientTypes = $this->em->getRepository(Client::class)->findClientTypes($id);
        $infoPDV = $this->em->getRepository(Client::class)->findClientInfoPDV($id);
        $tradeMarketing = $this->em->getRepository(Client::class)->tradMarketingPDV($id);
        $recetteP = $this->em->getRepository(MarketingRecette::class)->findall();
        $recetteS = $this->em->getRepository(MarketingRecette::class)->findall();
        $recetteSN = $this->em->getRepository(MarketingRecette::class)->findMarkby($recetteS_id);
        $recettePN = $this->em->getRepository(MarketingRecette::class)->findMarkby($recetteP_id);

        $client = [
            'Client_Information' => $clientInfo,
            "Client_Type_Info" => $clientTypes,
            "info_de_point_de_vente" => $infoPDV,
            "Information_trade_Markrting" => $tradeMarketing,
            "RecettePClient" => $recetteSN,
            "RecetteSClient" => $recettePN,
            "Stoke_MiniMum" => $stokeMin,
            "RecetteP" => $recetteP,
            "RecetteS" => $recetteS,
        ];
        return $this->successResponse($client);

    }

    /* public function stokeClient(array $stokeMin,int $id)
     {
         @ini_set('memory_limit',-1);
         //$client = $this->em->getRepository(Client::class)->find(1);
         //$stoke = $this->em->getRepository(Stoke::class)->findAll();
         $array=[];

         //Get ALL produit JTI
         $produit=$this->em->getRepository(Produit::class)->produitToStoke();

         $lenghtharray=count($produit);

         for($i=0;$i<$lenghtharray;$i++){
             //get Id of each Prodect
             $id_produit=$produit[$i]['id'];
             $nom_produit=$produit[$i]['label'];//print_r($produit);die();
             //get id Sotke of this Prodect
             //$id_stoke=$this->em->getRepository(Produit::class)->JTIid_stoke($id_produit);
             $id_stoke=$this->em->getRepository(Client::class)->JTIid_stokeClient($id_produit);//print_r($id_stoke);die();
          //   print_r($id_stoke);die();
             $lenghtharray=count($id_stoke);

             for($i=0;$i<$lenghtharray;$i++) {
                 $id_stoke = $id_stoke[$i]['id'];//print_r($id_stoke);die();
                 //get Quantiter of this Stoke
                 $stoke = $this->em->getRepository(Stoke::class)->find(11);

                 print_r($stoke->getProduit()->getnom());die();
             }

             $stoke_quantiter=$stoke->getStoke();
             array_push($array,['id'=>$id_produit,
                                  'nom'=>$nom_produit,
                                  'stoke'=>$stoke_quantiter]);
            // $stokes=[$id_produit,$nom_produit,$stoke_quantiter];
         }
         print_r( $array);die();
         die();

     }*/

    /**
     * @Rest\Get("/client/{id}/modifier", name="client_modifier_by_id")
     * @return Response\
     */
    public function modifierinfoPDV(int $id)
    {       //Client
        $client = $this->em->getRepository(Client::class)->find($id);
        $repo = $this->em->getRepository(Client::class);
        // info Client G1
        $codeClient = $client->getCodeClient();
        $licence = $client->getLicence();
        $decideur = $repo->findAlltypeDecideur();
        $repository = $this->em->getRepository(InfoClient::class);
        $infoClient = $repository->findModifinfClient($id);

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.sitation  FROM App\Entity\SituationFamilialle u ');
        $situation = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.age  FROM App\Entity\Age u ');
        $age = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.nbrEnfant  FROM App\Entity\NbrEnfant u ');
        $nbrEnfant = $query->getResult();

        // G2 Information PDV
        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\Region u ');
        $Region = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\Zone u ');
        $Zone = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\Gouvernorat u ');
        $gouvernerat = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\Deligation u ');
        $delegation = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\Quartier u ');
        $quartier = $query->getResult();

        $adress = $client->getAdress();
        $codePostale = $client->getCodePostal();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\PdvSuperficie u ');
        $PdvSuperficie = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.nbremployer  FROM App\Entity\NbrEmployer u ');
        $NbrEmployer = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\PdvEmplacements u ');
        $PdvEmplacements = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\PdvEnvironnements u ');
        $PdvEnvironnements = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\PdvTypesQuartier u ');
        $PdvTypesQuartier = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\PdvVisibilite u ');
        $PdvVisibilite = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\PdvClasses u ');
        $PdvClasses = $query->getResult();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\PdvTypologies u ');
        $PdvTypologies = $query->getResult();

        $accessPdv = $client->getInfoAccPdv();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\PdvPresentoire u ');
        $PdvPresentoire = $query->getResult();

        // info Trade Marketing G3
        $oneToOne = $client->getIsOneToOne();

        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\MarketingRegieTabac u ');
        $MarketingRegieTabac = $query->getResult();


        $query = $this->em
            ->createQuery('SELECT DISTINCT  u.id ,u.label  FROM App\Entity\MarketingCampagneEnCours u ');
        $MarketingCampagneEnCours = $query->getResult();

        $recetteP_id = $client->getRecetteP();
        $recetteP = $this->em->getRepository(MarketingRecette::class)->find($recetteP_id);

        $recetteS_id = $client->getRecetteS();
        $recetteS = $this->em->getRepository(MarketingRecette::class)->find($recetteS_id);


        $isTlp = $client->getIsTlp();
        $fsPotentiel = $client->getIsFsPotentiel();


        //  $repository = $this->em->getRepository(MarketingRecette::class);

        $infoClientGeneral[] = [
            'code_client' => $codeClient,
            'licence' => $licence,
            'decideur' => $decideur,
            'infofix' => $infoClient,
            'situation' => $situation,
            'age' => $age,
            'nbrEnfant' => $nbrEnfant
        ];
        $infoPdv[] = [
            'region' => $Region,
            'zone' => $Zone,
            'gouvernerat' => $gouvernerat,
            'delegation' => $delegation,
            'quartier' => $quartier,
            'adress' => $adress,
            'codePostale' => $codePostale,
            'pdvSuperficie' => $PdvSuperficie,
            'nbrEmployer' => $NbrEmployer,
            'pdvEmplacements' => $PdvEmplacements,
            'pdvEnvironnements' => $PdvEnvironnements,
            'pdvTypesQuartier' => $PdvTypesQuartier,
            'pdvVisibilite' => $PdvVisibilite,
            'pdvClasses' => $PdvClasses,
            'pdvTypologies' => $PdvTypologies,
            'accessPdv' => $accessPdv,
            'pdvPresentoire' => $PdvPresentoire,
        ];
        $tradMarketing[] = [
            'oneToOne' => $oneToOne,
            'marketingRegieTabac' => $MarketingRegieTabac,
            'recette_principale' => $recetteP,
            'recette_secondaire' => $recetteS,
            'tlp' => $isTlp,
            'fsPotentiel' => $fsPotentiel,
            'campagne_en_cours' => $MarketingCampagneEnCours,

        ];
       // $produits = $repo->findProuitsByClient($id);
        $produits = $this->em->getRepository(Client::class)->findClientsStoke($client);//dump($stokeMin);die();

        if (isset($client)) {
            return $this->successResponse(array(
                // info Client G1
                'infolient' => $infoClientGeneral,
                'infoPdv' => $infoPdv,
                'tradMarketing' => $tradMarketing,
                'produit' => $produits
            ));
        }
    }

    /**
     * @Rest\Post("/client/enregistrers", name="client_enregistrer")
     * @return Response
     */
    public function enregistrerinfoPDV(Request $request)
    {

        //           Start Stoke Min Saved Sheet G4
        $content = json_decode($request->getContent(), true);
        $id = $content['client_id'];
        $repo = $this->em->getRepository(Client::class);
        $client = $repo->find($id);//dump($client);die();
        $stokeArray = $content['stokeArray'];

        //Get prodect id and new stoke min for each prodect
        foreach ((array)$stokeArray as $element) {
            if (isset($element['id']) && isset($element['stoke'])) {
                $idproduit = $element['id'];
                $stoke = $element['stoke'];
                $StokeSheet = new StokeSheet();

                $Produittest1 = $this->em->getRepository(Produit::class)->find($idproduit);
                $StokeSheet->setProduit($Produittest1);

                $Clienttest1 = $this->em->getRepository(Client::class)->find($id);
                $StokeSheet->setClient($Clienttest1);

                $StokeSheet->setStokeSheet($stoke);
                $this->em->persist($StokeSheet);
                $this->em->flush();
            };
        }

        //              End Stoke Min

        $client_sheet = new Client();

        if (isset($client)) {
            // get id origenl client
            $client_sheet->setSheetClient($client ?? null);


            // Basic information
            $client_sheet->setCodeClient(($content["code_client"] == $client->getCodeClient())
                ? null : $content["code_client"]);

            $client_sheet->setLicence(($content["licence"] == $client->getLicence())
                ? null : $content["licence"]);


            $client_sheet->setAdress(($content["address"] == $client->getAdress())
                ? null : $content["address"]);

            $client_sheet->setCodePostal(($content["code_postal"] == $client->getCodePostal())
                ? null : $content["code_postal"]);

            $client_sheet->setLatitude(($content["latitude"] == $client->getLatitude())
                ? null : $content["latitude"]);

            $client_sheet->setLongitude(($content["longitude"] == $client->getLongitude())
                ? null : $content["longitude"]);

            $client_sheet->setInfoAccPdv(($content["is_acces_pdv"] == $client->getInfoAccPdv())
                ? null : $content["is_acces_pdv"]);

            $client_sheet->setDateSignature(($content["date_signature"] == $client->getDateSignature())
                ? null : $content["date_signature"]);

            $client_sheet->setDateInstalation(($content["date_instalation"] == $client->getDateInstalation())
                ? null : $request->request->get("date_instalation"));

            $client_sheet->setDateRappoort(($request->request->get("date_rappoort") == $client->getDateRappoort())
                ? null : $content["date_rappoort"]);

            $client_sheet->setIsTlp(($content["is_tlp"] == $client->getIsTlp())
                ? null : $content["is_tlp"]);

            $client_sheet->setVendeur(($content["vendeur"] ?? $client->getVendeur())
                ? null : $content["vendeur"]);

            $client_sheet->setJourVisite(($content["jour_visite"] ?? $client->getJourVisite())
                ? null : $content["jour_visite"]);

            $client_sheet->setIsActive(($content["is_active"] == $client->getIsActive())
                ? null : $content["is_active"]);

            $client_sheet->setIsOneToOne(($content["is_onetoone"] == $client->getIsOneToOne())
                ? null : $content["is_onetoone"]);

            $client_sheet->setIsFsPotentiel(($content["is_fs_potentiel"] == $client->getIsFsPotentiel())
                ? null : $content["is_fs_potentiel"]);

            //  $client_sheet->setCin(($content["cin"] == $client->getCin())
            //    ? null :$content["cin"]);

            $client_sheet->setNumLicence(($content["licence"] == $client->getNumLicence())
                ? null : $content["licence"]);


            // id Information on Relation
            $repoInfDecideur = $this->em->getRepository(TypeClient::class);
            $InfDecideur = $repoInfDecideur->find($content["decideur_id"]);

            $repoInfsuperficie = $this->em->getRepository(PdvSuperficie::class);
            $superficie = $repoInfsuperficie->find($content["superficie_id"]);


            $repoemplacement = $this->em->getRepository(PdvEmplacements::class);
            $emplacement = $repoemplacement->find($content["emplacement_id"]);

            $repoenvirenement = $this->em->getRepository(PdvEnvironnements::class);
            $envirenement = $repoenvirenement->find($content["envirenement_id"]);

            $repoPdvTypesQuartier = $this->em->getRepository(PdvTypesQuartier::class);
            $PdvTypesQuartier = $repoPdvTypesQuartier->find($content["typeDeQuartier_id"]);

            $repoPdvVisibilite = $this->em->getRepository(PdvVisibilite::class);
            $PdvVisibilite = $repoPdvVisibilite->find($content["visibiliter_id"]);

            $repoPdvClasses = $this->em->getRepository(PdvClasses::class);
            $PdvClasses = $repoPdvClasses->find($content["classe_id"]);

            $repoPdvTypologies = $this->em->getRepository(PdvTypologies::class);
            $PdvTypologies = $repoPdvTypologies->find($content["typologie_id"]);

            $repoPdvPresentoire = $this->em->getRepository(PdvPresentoire::class);
            $PdvPresentoire = $repoPdvPresentoire->find($content["presentoire_id"]);

            $repoPdvQuartier = $this->em->getRepository(Quartier::class);
            $PdvQuartier = $repoPdvQuartier->find($content["quartier_id"]);

            $repoMarketingRegieTabac = $this->em->getRepository(MarketingRegieTabac::class);
            $MarketingRegieTabac = $repoMarketingRegieTabac->find($content["regie_tabac_id"]);

            $repoMarketingCampagneEnCours = $this->em->getRepository(MarketingCampagneEnCours::class);
            $MarketingCampagneEnCours = $repoMarketingCampagneEnCours->find($content["Compagne_en_cour_id"]);

            $repoNbrEmployer = $this->em->getRepository(NbrEmployer::class);
            $NbrEmployer = $repoNbrEmployer->find($content["nbremployer_id"]);

            $repoMarketingRecette = $this->em->getRepository(MarketingRecette::class);
            $MarketingRecetteP = $repoMarketingRecette->find($content["rectteP_id"]);
            $MarketingRecetteS = $repoMarketingRecette->find($content["rectteS_id"]);

            $client_sheet->setDecider(($InfDecideur == $client->getDecider()) ? null : $InfDecideur);
            $client_sheet->setSuperficie(($superficie == $client->getSuperficie()) ? null : $superficie);
            $client_sheet->setEmplacement(($emplacement == $client->getEmplacement()) ? null : $emplacement);
            $client_sheet->setEnvironnement(($envirenement == $client->getEnvironnement()) ? null : $envirenement);
            $client_sheet->setQuartier(($PdvQuartier == $client->getQuartier()) ? null : $PdvQuartier);
            $client_sheet->setVisibiliter(($PdvVisibilite == $client->getVisibiliter()) ? null : $PdvVisibilite);
            $client_sheet->setClasse(($PdvClasses == $client->getClasse()) ? null : $PdvClasses);
            $client_sheet->setTypologie(($PdvTypologies == $client->getTypologie()) ? null : $PdvTypologies);
            $client_sheet->setPresentoire(($PdvPresentoire == $client->getPresentoire()) ? null : $PdvPresentoire);
            $client_sheet->setTypeDeQuartier(($PdvTypesQuartier == $client->getTypeDeQuartier()) ? null : $PdvTypesQuartier);
            $client_sheet->setRegieTabac(($MarketingRegieTabac == $client->getRegieTabac()) ? null : $MarketingRegieTabac);
            $client_sheet->setCompanieOncour(($MarketingCampagneEnCours == $client->getCompanieOncour()) ? null : $MarketingCampagneEnCours);


            //$client_sheet->setRecette(($MarketingRecette == $client->getRecette()) ? null : $MarketingRecette);
            $client_sheet->setRecetteP(($MarketingRecetteP == $client->getRecetteP()) ? null : $MarketingRecetteP);
            $client_sheet->setRecetteS(($MarketingRecetteS == $client->getRecetteS()) ? null : $MarketingRecetteS);

            $client_sheet->setNbrEmplyer(($NbrEmployer == $client->getNbrEmplyer()) ? null : $NbrEmployer);

            // Means that is Draft
            $client_sheet->setDraft(1);

            //
            $this->em->persist($client_sheet);
            $this->em->flush();
            $id_RapportPDV = $client_sheet->getId();

            //Titulaire 1
            $is_Titulaire = $content['is_Titulaire'];
            $Titulaire_AgeClient_id = $content['Titulaire_AgeClient_id'];
            $Titulaire_nbrEnfant_id = $content['Titulaire_nbrEnfant_id'];
            $Titulaire_situationFamil_id = $content['Titulaire_situationFamil_id'];
            $Titulaire_telephone = $content['Titulaire_telephone'];
            $Titulaire_nom = $content['Titulaire_nom'];

            //Gerant 2
            $is_Gerant = $content['is_Gerant'];
            $Gerant_AgeClient_id = $content['Gerant_AgeClient_id'];
            $Gerant_nbrEnfant_id = $content['Gerant_nbrEnfant_id'];
            $Gerant_situationFamil_id = $content['Gerant_situationFamil_id'];
            $Gerant_telephone = $content['Gerant_telephone'];
            $Gerant_nom = $content['Gerant_nom'];

            //Operateur 3
            $is_Operateur = $content['is_Operateur'];
            $Operateur_telephone = $content['Operateur_telephone'];
            $Operateur_nom = $content['Operateur_nom'];

            if ($is_Titulaire == true) {
                $infoClient = new InfoClient();
                $typeClient = $this->em->getRepository(TypeClient::class)->find(1);
                $infoClient->setTypeClientNew($typeClient);

                $Titulaire_AgeClient = $this->em->getRepository(Age::class)->find($Titulaire_AgeClient_id);
                $infoClient->setAgeClient($Titulaire_AgeClient);

                $Titulaire_nbrEnfant = $this->em->getRepository(NbrEnfant::class)->find($Titulaire_nbrEnfant_id);
                $infoClient->setNbrEnfant($Titulaire_nbrEnfant);

                $Titulaire_situationFamil = $this->em->getRepository(SituationFamilialle::class)->find($Titulaire_situationFamil_id);
                $infoClient->setSituationFamil($Titulaire_situationFamil);
                $infoClient->setTelephone($Titulaire_telephone);
                $infoClient->setNom($Titulaire_nom);
                $infoClient->setClient($client_sheet);
                $this->em->persist($infoClient);
                $this->em->flush();

            }

            if ($is_Gerant == true) {
                $infoClient = new InfoClient();
                $typeClient = $this->em->getRepository(TypeClient::class)->find(2);
                $infoClient->setTypeClientNew($typeClient);

                $Gerant_AgeClient = $this->em->getRepository(Age::class)->find($Gerant_AgeClient_id);
                $infoClient->setAgeClient($Gerant_AgeClient);

                $Gerant_nbrEnfant = $this->em->getRepository(NbrEnfant::class)->find($Gerant_nbrEnfant_id);
                $infoClient->setNbrEnfant($Gerant_nbrEnfant);

                $Gerant_situationFamil = $this->em->getRepository(SituationFamilialle::class)->find($Gerant_situationFamil_id);
                $infoClient->setSituationFamil($Gerant_situationFamil);

                $infoClient->setTelephone($Gerant_telephone);
                $infoClient->setNom($Gerant_nom);
                $infoClient->setClient($client_sheet);
                $this->em->persist($infoClient);
                $this->em->flush();

            }
            if ($is_Operateur == true) {
                $infoClient = new InfoClient();
                $typeClient = $this->em->getRepository(TypeClient::class)->find(3);
                $infoClient->setTypeClientNew($typeClient);
                $infoClient->setTelephone($Operateur_telephone);
                $infoClient->setNom($Operateur_nom);
                $infoClient->setClient($client_sheet);
                $this->em->persist($infoClient);
                $this->em->flush();
            }
            if (isset($content["commentText"]) && !empty($content["commentText"])) {
                $commentPdv = new Commentaire();
                $commentText = $content["commentText"];
                $commentPdv->setText($commentText);
                $CommentaireType = $this->em->getRepository(CommentaireType::class)->find(7);
                $commentPdv->setType($CommentaireType);
                //  $commentPdv->setClient($id_RapportPDV);
                $this->em->persist($commentPdv);
                $this->em->flush();
                $idComment = $commentPdv->getId();
                $commnet = $this->em->getRepository(Commentaire::class)->find($idComment);
                $client = $this->em->getRepository(Client::class)->find($id_RapportPDV);
                $client->addCommentPdv($commnet);

                $this->em->persist($client);
                $this->em->flush();
            }


            /*
                    // Image Upload SetUP
                    // $client_sheet = $this->em->getRepository(Client::class)->find(1);

                    $target_dir = $this->getParameter('rapport_file_directory');
                    //foreach ($_FILES as $fil){print_r($fil);}
                  //  $content = json_decode($request->getContent(), true);
                    //$images = $content['images'];

                    $total = \count($_FILES['images']['name']);
                   // print_r($total);
                  //  die();
                    if ($_FILES['images']) {
                        for ($i = 0; $i < $total; $i++) {
                            // File upload path
                            $fileName = basename($_FILES['images']['name'][$i]);
                            $avatar_name = $_FILES["images"]["name"][$i];
                            $avatar_tmp_name = $_FILES["images"]["tmp_name"][$i];
                            $error = $_FILES["images"]["error"][$i];
                            $targetFilePath = $target_dir . '/' . $fileName;
                            try {

                                $random_name = rand(1000, 1000000) . "-" . $avatar_name;
                                $upload_name = $targetFilePath . strtolower($random_name);
                                $upload_name = preg_replace('/\s+/', '-', $targetFilePath);
                                move_uploaded_file($avatar_tmp_name, $upload_name);
                              //  $FileNameRapport = '-RapportPdv-' . $fileName;
                                $file = new File();
                                $file->setLabel($fileName);
                                $file->setPath($targetFilePath);
                                $this->em->persist($file);
                                $this->em->flush();

                                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                            } catch (\Exception $e) {
                                echo json_encode($e);
                            }
                        }
                        $response = array(
                            "status" => "success",
                            "error" => false,
                            "message" => "File uploaded successfully",
                            "code" => "200"
                        );
                    } else {
                        $response = array(
                            "status" => "error",
                            "error" => true,
                            "message" => "No file was sent!",
                            "code" => "501"
                        );
                    }
                    // Upload file to server


                    return  $response;

                }
            */

        }
        if (http_response_code(200) == true) {
            return $this->successResponse([
                "code" => 200,
                "idPDVRapport" => $id_RapportPDV,
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
}