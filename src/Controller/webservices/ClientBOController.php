<?php

namespace App\Controller\webservices;

use App\Entity\Age;
use App\Entity\Client;
use App\Entity\ClientDraft;
use App\Entity\Deligation;
use App\Entity\File;
use App\Entity\Stoke;
use App\Entity\StokeContainer;
use App\Service\FileUploader;
use App\Entity\Gouvernorat;
use App\Entity\InfDecideur;
use App\Entity\InfoClient;
use App\Entity\MarketingCampagneEnCours;
use App\Entity\MarketingRecette;
use App\Entity\MarketingRegieTabac;
use App\Entity\Merch;
use App\Entity\NbrEmployer;
use App\Entity\NbrEnfant;
use App\Entity\OnePlanning;
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
use App\Entity\StokeSheet;
use App\Entity\TypeClient;
use App\Entity\Zone;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializerBuilder;
use League\Csv\Reader;
use League\Csv\Statement;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class ClientBOController extends MainController
{
    /**
     * @Rest\Get("/clients/showall", name="client_bo_show_all")
     */
    public function index(Request $request)
    {
        $customFindAll = "customFindAll";
        $data = $this->clientsToShowInBo($customFindAll, null);
        if (!empty($data)) {
            return $this->successResponse($data);
        } else {
            return $this->successResponse(["code" => 204, "message" => "No Content"]);
        }
    }

    /**
     * @Rest\Get("/clients/showallpagination", name="client_bo_show_all_with_paginator")
     */
    public function findClientsWithPagination(Request $request)
    {
        $customFindAll = "customFindAll";
        $data = $this->clientsToShowInBo($customFindAll, null);
        $pagination = $this->paginator->paginate(
            $data, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            self::NUMBER_ITEM_PER_PAGE /*limit per page*/
        );
        if (isset($pagination)) {
            return $this->successResponse($pagination);
        }
    }

    /**
     * @Rest\Get("/clients/{id}/bo", name="client_bo_show_by_id")
     */
    public function showByIdBo(int $id)
    {
        $client = $this->em->getRepository(Client::class)->find($id);
        if ($client) {
            if ($client->getFile()) {
                $clientImages = $client->getFile();
                foreach ($clientImages as $clientImage) {
                    $orderImages = (int)$clientImage->getClassment();
                    $imageId = $clientImage->getId();
                    $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
                    $imagePath = $protocol . $_SERVER['HTTP_HOST'] . $clientImage->getPath();
                    //$imagePath = 'http://'.$_SERVER['HTTP_HOST'].$clientImage->getPath();
                    if ($orderImages == self::IMAGE_LICENCE_CLASSMENT) {
                        $picturesLicence = ["id" => $imageId, "path" => $imagePath, "order" => $orderImages];
                    }
                    if ($orderImages == self::IMAGE_TITULAIRE_CLASSMENT) {
                        $picturesTitulaire = ["id" => $imageId, "path" => $imagePath, "order" => $orderImages];
                    }
                    if ($orderImages == self::IMAGE_GERANT_CLASSMENT) {
                        $picturesGerant = ["id" => $imageId, "path" => $imagePath, "order" => $orderImages];
                    }
                    if ($orderImages == self::IMAGE_OPERATEUR_CLASSMENT) {
                        $picturesOperateur = ["id" => $imageId, "path" => $imagePath, "order" => $orderImages];
                    }
                }
            }

            $routings = $this->em->getRepository(Client::class)->findAllRoutings($id);
            if ($routings) {
                $allRoutings = $routings;
            } else {
                $allRoutings = null;
            }

            if ($client->getDecider()) {
                $decideur_id = ($client->getDecider())->getId();
            } else {
                $decideur_id = null;
            }

            // Quartier
            if ($client->getQuartier()) {
                $quartier = $client->getQuartier();
                $quartier_id = $quartier->getId();
                $deligation = $quartier->getDeligation();
                $deligation_id = $deligation->getId();
                $gouvarnorat = $deligation->getGouvernorat();
                $gouvarnorat_id = $gouvarnorat->getId();
                $zone = $gouvarnorat->getZone();
                $zone_id = $zone->getId();
                $region = $zone->getRegion();
                $region_id = $region->getId();
            } else {
                $region_id = null;
                $zone_id = null;
                $gouvarnorat_id = null;
                $deligation_id = null;
                $quartier_id = null;
            }

            // Superficie
            if ($client->getSuperficie()) {
                $superficie = ($client->getSuperficie())->getId();
            } else {
                $superficie = null;
            }
            // Nombre d'employees
            if ($client->getNbrEmplyer()) {
                $emp_number = ($client->getNbrEmplyer())->getId();
            } else {
                $emp_number = null;
            }

            // Emplacement
            if ($client->getEmplacement()) {
                $infos_emplacement = ($client->getEmplacement())->getId();
            } else {
                $infos_emplacement = null;
            }
            // Environnement
            if ($client->getEnvironnement()) {
                $infos_environnement = ($client->getEnvironnement())->getId();
            } else {
                $infos_environnement = null;
            }
            // Type de quartier
            if ($client->getTypeDeQuartier()) {
                $infos_quartier = ($client->getTypeDeQuartier())->getId();
            } else {
                $infos_quartier = null;
            }
            // Visibilite
            if ($client->getVisibiliter()) {
                $infos_visibilite = ($client->getVisibiliter())->getId();
            } else {
                $infos_visibilite = null;
            }

            // Classe
            if ($client->getClasse()) {
                $classe_id = ($client->getClasse())->getId();
            } else {
                $classe_id = null;
            }

            // Typologie
            if ($client->getTypologie()) {
                $infos_typologie = ($client->getTypologie())->getId();
            } else {
                $infos_typologie = null;
            }

            // Presentoire
            if ($client->getPresentoire()) {
                $presentoire = ($client->getPresentoire())->getId();
            } else {
                $presentoire = null;
            }
            // Regie Tabac
            if ($client->getRegieTabac()) {
                $regie_tabac_id = ($client->getRegieTabac())->getId();
            } else {
                $regie_tabac_id = null;
            }
            // Compagne en cour
            if ($client->getCompanieOncour()) {
                $companie_oncour_id = ($client->getCompanieOncour())->getId();
            } else {
                $companie_oncour_id = null;
            }


            if ($client->getInfoClient()) {
                $infosClient = $client->getInfoClient();
                foreach ($infosClient as $infoClient) {
                    if ($infoClient->getTypeClientNew()) {
                        $typeClientId = ($infoClient->getTypeClientNew())->getId();

                        if ($infoClient->getSituationFamil()) {
                            $sit = ($infoClient->getSituationFamil())->getId();
                        } else {
                            $sit = null;
                        }

                        if ($infoClient->getNbrEnfant()) {
                            $nbrEnfants = ($infoClient->getNbrEnfant())->getId();
                        } else {
                            $nbrEnfants = null;
                        }

                        if ($infoClient->getAgeClient()) {
                            $age = ($infoClient->getAgeClient())->getId();
                        } else {
                            $age = null;
                        }
                        if ($infoClient->getNom()) {
                            $nom = $infoClient->getNom();
                        } else {
                            $nom = null;
                        }
                        if ($infoClient->getTelephone()) {
                            $telephone = $infoClient->getTelephone();
                        } else {
                            $telephone = null;
                        }
                        if ($typeClientId == self::TITULAIRE_ID) {
                            $infosTitulaire = [
                                "nomTitu" => $nom,
                                "telTitu" => $telephone,
                                "sitTitu" => $sit,
                                "nbrTitu" => $nbrEnfants,
                                "ageTitu" => $age
                            ];
                        } elseif ($typeClientId == self::GERANT_ID) {
                            $infosGerant = [
                                "nomGer" => $nom,
                                "telGer" => $telephone,
                                "sitGer" => $sit,
                                "nbrGer" => $nbrEnfants,
                                "ageGer" => $age
                            ];
                        } else {
                            $infosOperateur = [
                                "nomOp" => $nom,
                                "telOp" => $telephone
                            ];
                        }

                    }
                }
            }

            $data[] = [
                "id" => $client->getId(),
                "id_merch" => $client->getMerchId(),
                "codeClient" => $client->getCodeClient(),
                "licence" => $client->getLicence(),
                "decideur_id" => $decideur_id,
                "longitude" => $client->getLongitude(),
                "latitude" => $client->getLatitude(),
                "ville" => $client->getVille(),
                "vendeur" => $client->getVendeur(),
                "nom_titulaire" => $infosTitulaire["nomTitu"],
                "Titulaire_telephone" => $infosTitulaire["telTitu"],
                "Titulaire_situation_familiale" => $infosTitulaire["sitTitu"],
                "Titulaire_nombre_enfants" => $infosTitulaire["nbrTitu"],
                "Titulaire_age" => $infosTitulaire["ageTitu"],
                "Gerant_nom" => $infosGerant["nomGer"] ?? null,
                "Gerant_telephone" => $infosGerant["telGer"] ?? null,
                "Gerant_situation_familiale" => $infosGerant["sitGer"] ?? null,
                "Gerant_nombre_enfants" => $infosGerant["nbrGer"] ?? null,
                "Gerant_age" => $infosGerant["ageGer"] ?? null,
                "Operateur_nom" => $infosOperateur["nomOp"] ?? null,
                "Operateur_telephone" => $infosOperateur["telOp"] ?? null,
                "cin" => $client->getCin(),
                "region_id" => $region_id,
                "zone_id" => $zone_id,
                "gouvernorat_id" => $gouvarnorat_id,
                "deligation_id" => $deligation_id,
                "quartier" => $quartier_id,
                "address" => $client->getAdress(),
                "code_postal" => $client->getCodePostal(),
                "superficie" => $superficie,
                "emp_number" => $emp_number,
                "infos_emplacement" => $infos_emplacement,
                "infos_environnement" => $infos_environnement,
                "infos_quartier" => $infos_quartier,
                "infos_visibilite" => $infos_visibilite,
                "classe_id" => $classe_id,
                "infos_typologie" => $infos_typologie,
                "infos_acces_pdv" => $client->getInfoAccPdv(),
                "presentoire" => $presentoire,
                "is_one_to_one" => $client->getIsOneToOne(),
                "regie_tabac_id" => $regie_tabac_id,
                "recette_principale_id" => (int)$client->getRecetteP(),
                "recette_secondaire_id" => (int)$client->getRecetteS(),
                "client_tlp" => $client->getIsTlp(),
                "is_fs_potentiel" => $client->getIsFsPotentiel(),
                "companie_oncour_id" => $companie_oncour_id,
                "routings" => $allRoutings,
                "image_licence" => $picturesLicence ?? null,
                "image_titulaire" => $picturesTitulaire ?? null,
                "image_gerant" => $picturesGerant ?? null,
                "image_operateur" => $picturesOperateur ?? null,
            ];
            if (!empty($data)) {
                return $this->successResponse($data);
            } else {
                return $this->successResponse("No Data");
            }
        } else {
            return $this->successResponse(["code" => 204, "message" => "No Content"]);
        }
    }

    /**
     * Filter The Clients
     * @Rest\Post("/clients/showallpagination/filter", name="client_bo_show_all_with_paginator_filter")
     */
    public function findClientsWithPaginationFilter(Request $request)
    {
        // customFindAllFilter is a repo function to filter the clients
        $customFindAllFilter = "customFindAllFilter";
        // $arrayFiltrage = ["id"=>873,"label"=>"client"];
        $arrayFilterData = json_decode($request->getContent(), true);
        $arrayFiltrage = $arrayFilterData[0];

        $data = $this->clientsToShowInBo($customFindAllFilter, $arrayFiltrage);
        $pagination = $this->paginator->paginate(
            $data, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            self::NUMBER_ITEM_PER_PAGE /*limit per page*/
        );
        if (isset($pagination)) {
            return $this->successResponse($pagination);
        }
    }


    /**
     * id : id Client ( client Object created ) and the merch id get from newInstallPdv Object
     * @Rest\Get("/clients/{id}/by/{idMerch}/date", name="cliendatet_show_all_with_paginator")
     */
    /*    public function testDate(int $id, int $idMerch)
        {
            $dateInstall = new \DateTime("2019-07-09T03:00:00+00:00");
            $routings = $this->em->getRepository(Client::class)->findAllRoutings($id);
            foreach ($routings as $routing) {
                $idRouting = $routing["id"];
                // search date of routing in a (AM))
                $a = 'a';
                $onePlanningDateOfA = $this->em->getRepository(OnePlanning::class)->findRoutingsByMerch($a, $idRouting,
                    $idMerch);
                // search date of routing in am (PM))
                $am = 'am';
                $onePlanningDateOfAm = $this->em->getRepository(OnePlanning::class)->findRoutingsByMerch($am, $idRouting,
                    $idMerch);
                $idRoutings[] = $idRouting;
                //if(isset($onePlanningDateOfA) or isset($onePlanningDateOfAm)){
                $dates[] = array_merge($onePlanningDateOfA, $onePlanningDateOfAm);
                //  }else{$dates = null;}
            }

            if (!empty($dates)) {
                foreach ($dates as $key => $date) {
                    // var_dump($date);
                    if (!empty($date)) {
                        $day = $date[0]["day"];
                        if ($day >= $dateInstall) {
                            $data ["$key"] = $day->format('Y-m-d');
                        }
                    }
                }
            }
            // remove redundancy of dates
            $result = array_unique($data);
            //order the dates
            asort($result);
            if (isset($routings)) {
                return $this->successResponse(["routing" => $idRoutings, "dates" => $result]);
            }
        }*/

    /**
     * Custom Show Client For BO
     * The function get client filtring or without filtring
     *
     * @return Client[]|null
     * @var $array |null
     */
    public function clientsToShowInBo($findAllOrfindAllFilter, $arrayFiltrage)
    {
        //$arrayFiltrage = ["id"=>873,"label"=>"client"];

        $clients = $this->em->getRepository(Client::class)->$findAllOrfindAllFilter($arrayFiltrage ?? null);
        foreach ($clients as $client) {
            // $clientObject = $this->em->getRepository(Client::class)->find($client["id"]);
            $routings = $this->em->getRepository(Client::class)->findAllRoutings($client["id"]);
            if (isset($routings)) {
                $allRoutings = $routings;
            } else {
                $allRoutings = null;
            }
            $merchObject = $this->em->getRepository(Merch::class)->find((int)$client["merchId"]);
            if (isset($merchObject)) {
                $merchCode = $merchObject->getCode() . '-' . $merchObject->getFirstName() . ' ' . $merchObject->getLastName();
                $merchId = $merchObject->getId();
                $merch = ["id" => $merchId, "label" => $merchCode];
            } else {
                $merch = "-";
            }

            $data[] = array(
                "id" => $client["id"],
                "codeClient" => $client["codeClient"],
                "nom_titulaire" => $client["nom_titulaire"],
                "ville" => $client["ville"],
                "nombreAffectation" => $client["nmbAffectation"],
                "merch" => $merch,
                "routings" => $allRoutings
            );
            $allRoutings = null;
        }
        if (isset($data)) {
            return $data;
        } else {
            return null;
        }

    }


    /**
     * From BO
     * (codClient / nom_titulaire / routings ) obligatoire
     *
     * @Rest\Post("/client/create", name="clientbo_create")
     *
     * @return Response
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function create(Request $request)
    {
        // $em instanceof EntityManager
        $this->em->getConnection()->beginTransaction(); // suspend auto-commit
        try {
            if ($request->request->get("codeClient")) {
                $codeClient = $request->request->get("codeClient");
                $client = $this->em->getRepository(Client::class)->findOneBy([
                    "codeClient" => $codeClient
                ]);
                if (isset($client)) {
                    return $this->successResponse(["code" => 409, "message" => "Code: $codeClient deja existant"]);
                }
            } else {
                return $this->successResponse(["code" => 204, "message" => "Code Client Not Defined"]);
            }

            if ($request->request->get("decideur_id")) {
                $deciderObject = $this->em->getRepository(TypeClient::class)->find($request->request->get("decideur_id"));
            } else {
                $deciderObject = null;
            }

            if ($request->request->get("classe_id")) {
                $classeObject = $this->em->getRepository(PdvClasses::class)->find($request->request->get("classe_id"));
            } else {
                $classeObject = null;
            }

            if ($request->request->get("quartier")) {
                $quartierObject = $this->em->getRepository(Quartier::class)->find($request->request->get("quartier"));
            } else {
                $quartierObject = null;
            }

            if ($request->request->get("superficie")) {
                $superficieObject = $this->em->getRepository(PdvSuperficie::class)->find($request->request->get("superficie"));
            } else {
                $superficieObject = null;
            }

            if ($request->request->get("emp_number")) {
                $nbrEmployeeObject = $this->em->getRepository(NbrEmployer::class)->find($request->request->get("emp_number"));
            } else {
                $nbrEmployeeObject = null;
            }

            if ($request->request->get("infos_emplacement")) {
                $emplacementOject = $this->em->getRepository(PdvEmplacements::class)->find($request->request->get("infos_emplacement"));
            } else {
                $emplacementOject = null;
            }

            if ($request->request->get("infos_environnement")) {
                $environnementObject = $this->em->getRepository(PdvEnvironnements::class)->find($request->request->get("infos_environnement"));
            } else {
                $environnementObject = null;
            }

            if ($request->request->get("infos_quartier")) {
                $typeQuartierObject = $this->em->getRepository(PdvTypesQuartier::class)->find($request->request->get("infos_quartier"));
            } else {
                $typeQuartierObject = null;
            }

            if ($request->request->get("infos_visibilite")) {
                $visibiliteObject = $this->em->getRepository(PdvVisibilite::class)->find($request->request->get("infos_visibilite"));
            } else {
                $visibiliteObject = null;
            }

            if ($request->request->get("infos_typologie")) {
                $topologieObject = $this->em->getRepository(PdvTypologies::class)->find($request->request->get("infos_typologie"));
            } else {
                $topologieObject = null;
            }

            if ($request->request->get("presentoire")) {
                $presentoireObject = $this->em->getRepository(PdvPresentoire::class)->find($request->request->get("presentoire"));
            } else {
                $presentoireObject = null;
            }

            if ($request->request->get("regie_tabac_id")) {
                $regieTabacObject = $this->em->getRepository(MarketingRegieTabac::class)->find($request->request->get("regie_tabac_id"));
            } else {
                $regieTabacObject = null;
            }

            if ($request->request->get("recette_principale_id")) {
                $recettePrincipObject = (int)$request->request->get("recette_principale_id");
            } else {
                $recettePrincipObject = null;
            }

            if ($request->request->get("recette_secondaire_id")) {
                $recetteSecondObject = (int)$request->request->get("recette_secondaire_id");
            } else {
                $recetteSecondObject = null;
            }

            if ($request->request->get("companie_oncour_id")) {
                $companieOncourObject = $this->em->getRepository(MarketingCampagneEnCours::class)->find($request->request->get("companie_oncour_id"));
            } else {
                $companieOncourObject = null;
            }


            $client = new Client();
            if ($request->request->get("longitude")) {
                $client->setLongitude($request->request->get("longitude"));
            }
            if ($request->request->get("latitude")) {
                $client->setLatitude($request->request->get("latitude"));
            }
            if ($request->request->get("codeClient")) {
                $client->setCodeClient($request->request->get("codeClient"));
            } else {
                return $this->successResponse(["code" => 204, "message" => "Code Client Not Defined"]);
            }
            if ($request->request->get("ville")) {
                $client->setVille($request->request->get("ville"));
            }
            if ($request->request->get("licence")) {
                $client->setLicence($request->request->get("licence"));
            }
            if ($request->request->get("address")) {
                $client->setAdress($request->request->get("address"));
            }
            $client->setDecider($deciderObject);// obj
            if ($request->request->get("cin")) {
                $client->setCin($request->request->get("cin"));
            }
            $client->setClasse($classeObject); //obj
            $client->setQuartier($quartierObject);//obj
            if ($request->request->get("code_postal")) {
                $client->setCodePostal($request->request->get("code_postal"));
            }
            $client->setSuperficie($superficieObject); //obj
            $client->setNbrEmplyer($nbrEmployeeObject); //obj
            $client->setEmplacement($emplacementOject); //obj
            $client->setEnvironnement($environnementObject); // obj
            $client->setTypeDeQuartier($typeQuartierObject);//obj
            $client->setVisibiliter($visibiliteObject);//obj
            $client->setTypologie($topologieObject);// obj
            if ($request->request->get("infos_acces_pdv")) {
                $client->setInfoAccPdv($request->request->get("infos_acces_pdv"));
            } // true/false
            $client->setPresentoire($presentoireObject);//obj
            if ($request->request->get("is_one_to_one")) {
                $client->setIsOneToOne($request->request->get("is_one_to_one"));
            }// true/false
            $client->setRegieTabac($regieTabacObject); //obj
            $client->setRecetteP($recettePrincipObject);
            $client->setRecetteS($recetteSecondObject);

            if ($request->request->get("client_tlp")) {
                $client->setIsTlp($request->request->get("client_tlp"));
            } // true/false
            if ($request->request->get("vendeur")) {
                $client->setVendeur($request->request->get("vendeur"));
            }
            if ($request->request->get("id_merch")) {
                $client->setMerchId($request->request->get("id_merch"));
            }

            if ($request->request->get("is_fs_potentiel")) {
                $client->setIsFsPotentiel($request->request->get("is_fs_potentiel"));
            } // true/false

            $client->setCompanieOncour($companieOncourObject); // obj

            //Routings
            if ($request->request->get("routings")) {
                $routingsId = $request->request->get("routings");
                if (!empty($routingsId)) {
                    foreach ($routingsId as $routing) {
                        $routingObject = $this->em->getRepository(Routing::class)->find($routing["id"]);
                        $client->addRouting($routingObject);
                    }
                    // $client->setNmbAffectation(count($routingsId));
                }
            }

            // I set the default number 0( this will be treated with angular in front)
            $client->setNmbAffectation(0);
            $client->setDraft(0);
            $this->em->persist($client);
            $this->em->flush();

            //*************************Stoke ********************************************************//
            $id = $client->getId();
            $existClient = $this->em->getRepository(Client::class)->find($id);
            $content = json_decode($request->getContent(), true);

            //We have not  Container then :
            // ------------------------------
            //Case Client Haven't à ContainerStokeId at ALL
            //Creat New Stoke Container and affect it To Client
            $stokeContainer = new StokeContainer();
            $this->em->persist($stokeContainer);
            $this->em->flush();
            $idContainer = $stokeContainer->getId();

            //find New Stoke Contianer and set it to client
            $stokeContainerObj = $this->em->getRepository(StokeContainer::class)->find($idContainer);
            //affect this new container to this Client
            $existClient->setStokeContainer($stokeContainerObj);
            $this->em->persist($existClient);
            $this->em->flush();
            // We have Tow Case Here 1erst one User don't send Quantiter of each Product
            $stokeArray = $content['stokeArray'];
            /*  $stokeArray = array(
                  '0' => [
                      'id' => 1,
                      'qte' => 8888
                  ],
                  '1' => [
                      'id' => 4,
                      'qte' => 8888
                  ],
                  '2' => [
                      'id' => 5,
                      'qte' => 8888
                  ],
                  '3' => [
                      'id' => 6,
                  ],

              );*/
            //Get All prodect JTI To Set All of them To our Container Client
            $produitsListeID = $this->em->getRepository(Produit::class)->produitBONOtJTIAuto();

            if (!isset($stokeArray)) {
                // if (!isset($stokeArray)) {
                foreach ($produitsListeID as $key => $value) {
                    // Get prodect By Id
                    $id_Produit = $value["id"];
                    $produit = $this->em->getRepository(Produit::class)->find($id_Produit);
                    //Creat New Stoke
                    $quantiter = 0;
                    $stoke = new Stoke();
                    $stoke->setQuantiter($quantiter);
                    $stoke->setProduit($produit);
                    $stoke->setStokeContainer($stokeContainerObj);
                    $this->em->persist($stoke);
                    $this->em->flush();
                }

            } else {
                // this in Case Client Have No container And user Send Product Id And quantite
                foreach ((array)$stokeArray as $element) {
                    if (isset($element['id'])) {
                        //get product quantiter and Id
                        $id_Produit = $element['id'];
                        if (isset($element['qte'])) {
                            $quantiter = $element['qte'];
                        } else {
                            $quantiter = 0;
                        }
                        //$quantiter = $element['quantiter']?? 0;
                        // Get produit Objet
                        $produit = $this->em->getRepository(Produit::class)->find($id_Produit);
                        // Set this Product Obj To Stoke
                        $stoke = new Stoke();
                        $stoke->setQuantiter($quantiter);
                        $stoke->setProduit($produit);                        //Set this stoke to the new Container
                        $stoke->setStokeContainer($stokeContainerObj);
                        $this->em->persist($stoke);
                        $this->em->flush();
                    }
                }
            }

            //**************************the End Stoke ********************************************************//

            /****** info Client entity ************/

            // Titulaire
            $infoClientTitulaire = new InfoClient();
            $typeTitulaireClient = $this->em->getRepository(TypeClient::class)->find(self::TITULAIRE_ID); //  1:Titulaire
            if ($request->request->get("nom_titulaire")) {
                $infoClientTitulaire->setNom($request->request->get("nom_titulaire"));
            } else {
                return $this->successResponse(["code" => 204, "message" => "Nom Titulaire Not Defined"]);
            }
            if ($request->request->get("Titulaire_telephone")) {
                $infoClientTitulaire->setTelephone($request->request->get("Titulaire_telephone"));
            }
            $infoClientTitulaire->setTypeClientNew($typeTitulaireClient);

            if ($request->request->get("Titulaire_situation_familiale")) {
                $titulaireSituationFam = $this->em->getRepository(SituationFamilialle::class)->find($request->request->get("Titulaire_situation_familiale"));
                $infoClientTitulaire->setSituationFamil($titulaireSituationFam);
            }

            if ($request->request->get("Titulaire_nombre_enfants")) {
                $titulaireNbrEnfants = $this->em->getRepository(NbrEnfant::class)->find($request->request->get("Titulaire_nombre_enfants"));
                $infoClientTitulaire->setNbrEnfant($titulaireNbrEnfants);
            }

            if ($request->request->get("Titulaire_age")) {
                $titulaireAge = $this->em->getRepository(Age::class)->find($request->request->get("Titulaire_age"));
                $infoClientTitulaire->setAgeClient($titulaireAge);
            }
            $infoClientTitulaire->setClient($client);
            $this->em->persist($infoClientTitulaire);

            // Gerant
            $infoClientGerant = new InfoClient();

            if ($request->request->get("Gerant_nom")
                or $request->request->get("Gerant_telephone")
                or $request->request->get("Gerant_situation_familiale")
                or $request->request->get("Gerant_nombre_enfants")
                or $request->request->get("Gerant_age")) {


                if ($request->request->get("Gerant_nom")) {
                    $infoClientGerant->setNom($request->request->get("Gerant_nom"));
                }
                if ($request->request->get("Gerant_telephone")) {
                    $infoClientGerant->setTelephone($request->request->get("Gerant_telephone"));
                }
                $typeGerantClient = $this->em->getRepository(TypeClient::class)->find(self::GERANT_ID); //  2:Gerant
                if (isset($typeGerantClient)) {
                    $infoClientGerant->setTypeClientNew($typeGerantClient);//obj
                }
                if ($request->request->get("Gerant_situation_familiale")) {
                    $gerantSituationFam = $this->em->getRepository(SituationFamilialle::class)->find($request->request->get("Gerant_situation_familiale"));
                    if (isset($gerantSituationFam)) {
                        $infoClientGerant->setSituationFamil($gerantSituationFam);//obj
                    }
                }
                if ($request->request->get("Gerant_nombre_enfants")) {
                    $gerantNbrEnfants = $this->em->getRepository(NbrEnfant::class)->find($request->request->get("Gerant_nombre_enfants"));
                    if (isset($gerantNbrEnfants)) {
                        $infoClientGerant->setNbrEnfant($gerantNbrEnfants);//obj
                    }
                }
                if ($request->request->get("Gerant_age")) {
                    $gerantAge = $this->em->getRepository(Age::class)->find($request->request->get("Gerant_age"));
                    if (isset($gerantAge)) {
                        $infoClientGerant->setAgeClient($gerantAge); //obj
                    }
                }
                $infoClientGerant->setClient($client);
                $this->em->persist($infoClientGerant);
            }


            // Operateur
            $infoClientOperateur = new InfoClient();
            if ($request->request->get("Operateur_nom") or $request->request->get("Operateur_telephone")) {

                if ($request->request->get("Operateur_nom")) {
                    $infoClientOperateur->setNom($request->request->get("Operateur_nom"));
                }
                if ($request->request->get("Operateur_telephone")) {
                    $infoClientOperateur->setTelephone($request->request->get("Operateur_telephone"));
                }
                $typeOperateurClient = $this->em->getRepository(TypeClient::class)->find(self::OPERATEUR_ID); //  3:Operateur
                if (isset($typeOperateurClient)) {
                    $infoClientOperateur->setTypeClientNew($typeOperateurClient);
                }
                $infoClientOperateur->setClient($client);
                $this->em->persist($infoClientOperateur);
            }

            /*************** Stock Min **********************/
            /*     $stockArray = $request->request->get('stockArray');
                 if($stockArray){
                     foreach ($stockArray as $element) {
                         if (isset($element['id']) && isset($element['stock'])) {
                             $idproduit = $element['id'];
                             $stock = $element['stock'];
                             $stockSheet = new StokeSheet();
                             $productObject = $this->em->getRepository(Produit::class)->find($idproduit);
                             $stockSheet->setProduit($productObject);
                             $stockSheet->setClient($client);
                             $stockSheet->setStokeSheet($stock);

                             $this->em->persist($stockSheet);
                             $this->em->flush();
                         };
                     }
                 }*/


            /*************** Photos (4)**********************/

            $fileUploader = new  FileUploader($this->getParameter('images_pos_directory'));
            // Licence Image
            if ($request->files->get('image_licence')) {
                $uplodedImage = $request->files->get('image_licence');
                $fileName = $fileUploader->upload($uplodedImage);
                $pathLicencePhoto = '/uploads/pos/' . $fileName;
                $this->saveImageFile($fileName, $pathLicencePhoto, self::IMAGE_LICENCE_CLASSMENT, $client);
            }

            // Titulaire Image (order 0)
            if ($request->files->get('image_titulaire')) {
                $uplodedImage = $request->files->get('image_titulaire');
                $fileName = $fileUploader->upload($uplodedImage);
                $pathTitulaireImage = '/uploads/pos/' . $fileName;
                $this->saveImageFile($fileName, $pathTitulaireImage, self::IMAGE_TITULAIRE_CLASSMENT, $client);
            }

            // Gerant Image (order 1)
            if ($request->files->get('image_gerant')) {
                $uplodedImage = $request->files->get('image_gerant');
                $fileName = $fileUploader->upload($uplodedImage);
                $pathGerantImage = '/uploads/pos/' . $fileName;
                $this->saveImageFile($fileName, $pathGerantImage, self::IMAGE_GERANT_CLASSMENT, $client);
            }
            // Operateur Image (order 2)
            if ($request->files->get('image_operateur')) {
                $uplodedImage = $request->files->get('image_operateur');
                $fileName = $fileUploader->upload($uplodedImage);
                $pathGerantImage = '/uploads/pos/' . $fileName;
                $this->saveImageFile($fileName, $pathGerantImage, self::IMAGE_OPERATEUR_CLASSMENT, $client);
            }

            $this->em->getConnection()->commit(); // transaction part
            $this->em->flush();
            $data = $this->reternDataToShowInBo($client);
            if ($data) {
                return $this->successResponse($data);
            } else {
                return $this->successResponse(["code" => 204, "message" => "No Content"]);
            }


        } catch (Exception $e) {
            $this->em->getConnection()->rollBack();
            throw $e;
        }
    }

    /**
     * Update Client From BO
     * @Rest\Post("/client/{id}/update", name="client_bo_update")
     * @return Response
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function update(Request $request, int $id)
    {
        // remarque : this Work just on Case Client is existe

        /// ====> Stoke in tow case  client have not container  or update
        $existClient = $this->em->getRepository(Client::class)->find($id);
        $content = json_decode($request->getContent(), true);
        /* if(!is_null($existClient->getStokeContainer())){
             $isStokeContainerId = $existClient->getStokeContainer()->getId();
         }*/
        // dump(!is_null($existClient->getStokeContainer()));die();


        //get Container Id From Client ID
        //check is there Container or not
        if (!is_null($existClient->getStokeContainer())) {
            //We have  Container then :
            // ------------------------------
            $isStokeContainerId = $existClient->getStokeContainer()->getId();
            // If  Client has $isStokeContainerId  then  we gonne Update Stoke Client
            // user gonne send product id and quantiter

            $stokeArray = $content['stokeArray'];
            /* $stokeArray = array(
                 '0' => [
                     'id' => 1,
                     'qte' => 444444
                 ],
                 '1' => [
                     'id' => 4,
                     'qte' => 444444
                 ],
                 '2' => [
                     'id' => 5,
                     'qte' => 444444
                 ],
                 '3' => [
                     'id' => 6,
                     'qte' => 444444
                 ]
             );*/
            //Get prodect id and new stoke  for each prodect
            foreach ((array)$stokeArray as $element) {
                if (isset($element['id']) && isset($element['qte'])) {
                    //get product quantiter and Id
                    $idproduit = $element['id'];
                    $Quantiter = $element['qte'];
                    //Get stoke of this client by ContainerID and id product cause containerID is unique for each client
                    $Stoke_ID = $this->em->getRepository(Stoke::class)->findStokeByContainerID($isStokeContainerId,
                        $idproduit);
                    //Select  from Stoke_ID the Stoke Id related To this product
                    foreach ((array)$Stoke_ID as $element2) {
                        $StokeIdThiProdect = $element2['id'];
                    }
                    //after we Got the StokeId related whith this prodect we gonn get stoke object
                    //To Update the quantiter of this prodect  & persist it
                    $stoke = $this->em->getRepository(Stoke::class)->find($StokeIdThiProdect);
                    $stoke->setQuantiter($Quantiter);
                    $this->em->persist($stoke);
                    $this->em->flush();

                };
            }


        } else {
            //We have not  Container then :
            // ------------------------------
            //Case Client Haven't à ContainerStokeId at ALL
            //Creat New Stoke Container and affect it To Client
            $stokeContainer = new StokeContainer();
            $this->em->persist($stokeContainer);
            $this->em->flush();
            $idContainer = $stokeContainer->getId();

            //find New Stoke Contianer and set it to client
            $stokeContainerObj = $this->em->getRepository(StokeContainer::class)->find($idContainer);
            //affect this new container to this Client
            $existClient->setStokeContainer($stokeContainerObj);
            $this->em->persist($existClient);
            $this->em->flush();


            // We have Tow Case Here 1erst one User don't send Quantiter of each Product

            $stokeArray = $content['stokeArray'];
            /*  $stokeArray = array(
                  '0' => [
                      'id' => 1,
                      'qte' => 8888
                  ],
                  '1' => [
                      'id' => 4,
                      'qte' => 8888
                  ],
                  '2' => [
                      'id' => 5,
                      'qte' => 8888
                  ],
                  '3' => [
                      'id' => 6,
                  ],

              );*/
            //Get All prodect JTI To Set All of them To our Container Client
            $produitsListeID = $this->em->getRepository(Produit::class)->produitBONOtJTIAuto();

            if (!isset($stokeArray)) {
                // if (!isset($stokeArray)) {
                foreach ($produitsListeID as $key => $value) {
                    // Get prodect By Id
                    $id_Produit = $value["id"];
                    $produit = $this->em->getRepository(Produit::class)->find($id_Produit);
                    //Creat New Stoke
                    //  $quantiter = ($request->request->get("quantiter")) ?? 0;
                    $quantiter = 0;
                    $stoke = new Stoke();
                    $stoke->setQuantiter($quantiter);
                    $stoke->setProduit($produit);
                    $stoke->setStokeContainer($stokeContainerObj);
                    $this->em->persist($stoke);
                    $this->em->flush();
                }


            } else {
                // this in Case Client Have No container And user Send Product Id And quantite
                foreach ((array)$stokeArray as $element) {
                    if (isset($element['id'])) {
                        //get product quantiter and Id
                        $id_Produit = $element['id'];
                        if (isset($element['qte'])) {
                            $quantiter = $element['qte'];
                        } else {
                            $quantiter = 0;
                        }
                        //$quantiter = $element['quantiter']?? 0;
                        // Get produit Objet
                        $produit = $this->em->getRepository(Produit::class)->find($id_Produit);
                        // Set this Product Obj To Stoke
                        $stoke = new Stoke();
                        $stoke->setQuantiter($quantiter);
                        $stoke->setProduit($produit);
                        //Set this stoke to the new Container
                        $stoke->setStokeContainer($stokeContainerObj);
                        $this->em->persist($stoke);
                        $this->em->flush();
                    }
                }
            }

        }

        // Response Part
      /*  if (http_response_code(200) == true) {
            return $this->successResponse([
                "code" => 200,
                "status" => "success",
                "error" => false,
                "message" => "Update  product of this client whith success "
            ]);
        } else {
            if (http_response_code(500) == true) {
                return $this->successResponse(["message" => "erreur interne du serveur"]);
            } else {
                return $this->successResponse([http_response_code()]);
            }
        }*/

/// ====> Stoke in tow case new client or update   ===>END<====//
        if (isset($existClient)) {
            if ($request->request->get("codeClient")) {
                $codeClient = $request->request->get("codeClient");
                $existClientCode = $this->em->getRepository(Client::class)->findOneBy([
                    "codeClient" => $codeClient
                ]);
                if ($existClientCode) {
                    return $this->successResponse(["code" => 409, "message" => "Code Exist"]);
                } else {
                    $existClient->setCodeClient($codeClient);
                }

            } else {
                $existClient->setCodeClient($existClient->getCodeClient());
            }

            if ($request->request->get("decideur_id")) {
                $deciderObject = $this->em->getRepository(TypeClient::class)->find($request->request->get("decideur_id"));
            } else {
                $deciderObject = $existClient->getDecider();
            }

            if ($request->request->get("classe_id")) {
                $classeObject = $this->em->getRepository(PdvClasses::class)->find($request->request->get("classe_id"));
            } else {
                $classeObject = $existClient->getClasse();
            }

            if ($request->request->get("quartier")) {
                $quartierObject = $this->em->getRepository(Quartier::class)->find($request->request->get("quartier"));
            } else {
                $quartierObject = $existClient->getQuartier();
            }

            if ($request->request->get("superficie")) {
                $superficieObject = $this->em->getRepository(PdvSuperficie::class)->find($request->request->get("superficie"));
            } else {
                $superficieObject = $existClient->getSuperficie();
            }

            if ($request->request->get("emp_number")) {
                $nbrEmployeeObject = $this->em->getRepository(NbrEmployer::class)->find($request->request->get("emp_number"));
            } else {
                $nbrEmployeeObject = $existClient->getNbrEmplyer();
            }

            if ($request->request->get("infos_emplacement")) {
                $emplacementOject = $this->em->getRepository(PdvEmplacements::class)->find($request->request->get("infos_emplacement"));
            } else {
                $emplacementOject = $existClient->getEmplacement();
            }

            if ($request->request->get("infos_environnement")) {
                $environnementObject = $this->em->getRepository(PdvEnvironnements::class)->find($request->request->get("infos_environnement"));
            } else {
                $environnementObject = $existClient->getEnvironnement();
            }

            if ($request->request->get("infos_quartier")) {
                $typeQuartierObject = $this->em->getRepository(PdvTypesQuartier::class)->find($request->request->get("infos_quartier"));
            } else {
                $typeQuartierObject = $existClient->getTypeDeQuartier();
            }

            if ($request->request->get("infos_visibilite")) {
                $visibiliteObject = $this->em->getRepository(PdvVisibilite::class)->find($request->request->get("infos_visibilite"));
            } else {
                $visibiliteObject = $existClient->getVisibiliter();
            }

            if ($request->request->get("infos_typologie")) {
                $topologieObject = $this->em->getRepository(PdvTypologies::class)->find($request->request->get("infos_typologie"));
            } else {
                $topologieObject = $existClient->getTypologie();
            }

            if ($request->request->get("presentoire")) {
                $presentoireObject = $this->em->getRepository(PdvPresentoire::class)->find($request->request->get("presentoire"));
            } else {
                $presentoireObject = $existClient->getPresentoire();
            }

            if ($request->request->get("regie_tabac_id")) {
                $regieTabacObject = $this->em->getRepository(MarketingRegieTabac::class)->find($request->request->get("regie_tabac_id"));
            } else {
                $regieTabacObject = $existClient->getRegieTabac();
            }

            if ($request->request->get("recette_principale_id")) {
                $recettePrincipObject = (int)$request->request->get("recette_principale_id");
            } else {
                $recettePrincipObject = $existClient->getRecetteP();
            }

            if ($request->request->get("recette_secondaire_id")) {
                $recetteSecondObject = (int)$request->request->get("recette_secondaire_id");
            } else {
                $recetteSecondObject = $existClient->getRecetteS();
            }

            if ($request->request->get("companie_oncour_id")) {
                $companieOncourObject = $this->em->getRepository(MarketingCampagneEnCours::class)->find($request->request->get("companie_oncour_id"));
            } else {
                $companieOncourObject = $existClient->getCompanieOncour();
            }


            if ($request->request->get("longitude")) {
                $existClient->setLongitude($request->request->get("longitude") ?? $existClient->getLongitude());
            }
            if ($request->request->get("latitude")) {
                $existClient->setLatitude($request->request->get("latitude") ?? $existClient->getLatitude());
            }
            if ($request->request->get("codeClient")) {
                $existClient->setCodeClient($request->request->get("codeClient") ?? $existClient->getCodeClient());
            }
            if ($request->request->get("ville")) {
                $existClient->setVille($request->request->get("ville") ?? $existClient->getVille());
            }
            if ($request->request->get("licence")) {
                $existClient->setLicence($request->request->get("licence") ?? $existClient->getLicence());
            }
            if ($request->request->get("address")) {
                $existClient->setAdress($request->request->get("address") ?? $existClient->getAdress());
            }
            $existClient->setDecider($deciderObject);// obj
            if ($request->request->get("cin")) {
                $existClient->setCin($request->request->get("cin") ?? $existClient->getCin());
            }
            $existClient->setClasse($classeObject); //obj
            $existClient->setQuartier($quartierObject);//obj
            if ($request->request->get("code_postal")) {
                $existClient->setCodePostal($request->request->get("code_postal") ?? $existClient->getCodePostal());
            }
            $existClient->setSuperficie($superficieObject); //obj
            $existClient->setNbrEmplyer($nbrEmployeeObject); //obj
            $existClient->setEmplacement($emplacementOject); //obj
            $existClient->setEnvironnement($environnementObject); // obj
            $existClient->setTypeDeQuartier($typeQuartierObject);//obj
            $existClient->setVisibiliter($visibiliteObject);//obj
            $existClient->setTypologie($topologieObject);// obj
            if ($request->request->get("infos_acces_pdv") === "true") {
                $existClient->setInfoAccPdv(true);
            } else {
                $existClient->setInfoAccPdv(false);
            }// true/false
            $existClient->setPresentoire($presentoireObject);//obj
            if ($request->request->get("is_one_to_one") === "true") {
                $existClient->setIsOneToOne(true);
            } else {
                $existClient->setIsOneToOne(false);
            }
            $existClient->setRegieTabac($regieTabacObject); //obj
            $existClient->setRecetteP($recettePrincipObject);
            $existClient->setRecetteS($recetteSecondObject);

            if ($request->request->get("client_tlp") === "true") {
                $existClient->setIsTlp(true);
            } else {
                $existClient->setIsTlp(false);
            }
            if ($request->request->get("vendeur")) {
                $existClient->setVendeur($request->request->get("vendeur") ?? $existClient->getVendeur());
            }
            if ($request->request->get("id_merch")) {
                $existClient->setMerchId($request->request->get("id_merch") ?? $existClient->getMerchId());
            }

            if ($request->request->get("is_fs_potentiel") === "true") {
                $existClient->setIsFsPotentiel(true);
            } else {
                $existClient->setIsFsPotentiel(false);
            }
            $existClient->setCompanieOncour($companieOncourObject); // obj


            //Routings
            if ($request->request->get("routings")) {
                // Get the new routings ids
                $routingsId = $request->request->get("routings");
                foreach ($routingsId as $routing) {
                    // Than add the new routings
                    $routingObject = $this->em->getRepository(Routing::class)->find($routing["id"]);
                    // Check if the routing is already added for the Client
                    $isRoutingExist = $this->checkIfClientRoutingExist($existClient, $routing["id"]);
                    if ($isRoutingExist == false) {
                        $existClient->addRouting($routingObject);
                        // add number of pos in the routing
                        $routingObject->setNbrsPdv($routingObject->getNbrsPdv() + 1);
                        $this->em->persist($routingObject);
                        $this->em->flush();
                    }
                }
                $existClient->setNmbAffectation(count($routingsId));
                // save the exist routing of client
                $this->cleanRoutingClient($existClient, $routingsId);
            } else {
                $this->removeExistRoutings($existClient);
            }

            $existClient->setDraft(0);
            $this->em->persist($existClient);
            $this->em->flush();

            /****** update info Client ************/

            // Update Titulaire
            if ($request->request->get("nom_titulaire")
                or $request->request->get("Titulaire_telephone")
                or $request->request->get("Titulaire_situation_familiale")
                or $request->request->get("Titulaire_nombre_enfants")
                or $request->request->get("Titulaire_age")) {

                //
                $infoClientTitulaire = $this->em->getRepository(InfoClient::class)->findOneBy([
                    "client" => $existClient,
                    "typeClientNew" => self::TITULAIRE_ID
                ]);
                if ($infoClientTitulaire) {
                    if ($request->request->get("nom_titulaire")) {
                        $infoClientTitulaire->setNom($request->request->get("nom_titulaire"));
                    }
                    if ($request->request->get("Titulaire_telephone")) {
                        $infoClientTitulaire->setTelephone($request->request->get("Titulaire_telephone"));
                    }
                    $typeTitulaireClient = $this->em->getRepository(TypeClient::class)->find(self::TITULAIRE_ID);
                    if (isset($typeTitulaireClient)) {
                        $infoClientTitulaire->setTypeClientNew($typeTitulaireClient);//obj
                    }
                    if ($request->request->get("Titulaire_situation_familiale")) {
                        $titulaireSituationFam = $this->em->getRepository(SituationFamilialle::class)->find($request->request->get("Titulaire_situation_familiale"));
                        if (isset($titulaireSituationFam)) {
                            $infoClientTitulaire->setSituationFamil($titulaireSituationFam);//obj
                        }
                    }
                    if ($request->request->get("Titulaire_nombre_enfants")) {
                        $titulairetNbrEnfants = $this->em->getRepository(NbrEnfant::class)->find($request->request->get("Titulaire_nombre_enfants"));
                        if (isset($titulairetNbrEnfants)) {
                            $infoClientTitulaire->setNbrEnfant($titulairetNbrEnfants);//obj
                        }
                    }
                    if ($request->request->get("Titulaire_age")) {
                        $titulaireAge = $this->em->getRepository(Age::class)->find($request->request->get("Titulaire_age"));
                        if (isset($titulaireAge)) {
                            $infoClientTitulaire->setAgeClient($titulaireAge); //obj
                        }
                    }
                    $this->em->persist($infoClientTitulaire);
                    $this->em->flush();
                }
            }

            // Update Gerant
            if ($request->request->get("Gerant_nom")
                or $request->request->get("Gerant_telephone")
                or $request->request->get("Gerant_situation_familiale")
                or $request->request->get("Gerant_nombre_enfants")
                or $request->request->get("Gerant_age")) {

                //
                $infoClientGerant = $this->em->getRepository(InfoClient::class)->findOneBy([
                    "client" => $existClient,
                    "typeClientNew" => self::GERANT_ID
                ]);

                if ($infoClientGerant) {
                    if ($request->request->get("Gerant_nom")) {
                        $infoClientGerant->setNom($request->request->get("Gerant_nom"));
                    }
                    if ($request->request->get("Gerant_telephone")) {
                        $infoClientGerant->setTelephone($request->request->get("Gerant_telephone") ?? $infoClientGerant->getTelephone());
                    }
                    $typeGerantClient = $this->em->getRepository(TypeClient::class)->find(self::GERANT_ID);
                    if (isset($typeGerantClient)) {
                        $infoClientGerant->setTypeClientNew($typeGerantClient);//obj
                    }
                    if ($request->request->get("Gerant_situation_familiale")) {
                        $gerantSituationFam = $this->em->getRepository(SituationFamilialle::class)->find($request->request->get("Gerant_situation_familiale"));
                        if (isset($gerantSituationFam)) {
                            $infoClientGerant->setSituationFamil($gerantSituationFam ?? $infoClientGerant->getSituationFamil());//obj
                        }
                    }
                    if ($request->request->get("Gerant_nombre_enfants")) {
                        $gerantNbrEnfants = $this->em->getRepository(NbrEnfant::class)->find($request->request->get("Gerant_nombre_enfants"));
                        if (isset($gerantNbrEnfants)) {
                            $infoClientGerant->setNbrEnfant($gerantNbrEnfants ?? $infoClientGerant->getNbrEnfant());//obj
                        }
                    }
                    if ($request->request->get("Gerant_age")) {
                        $gerantAge = $this->em->getRepository(Age::class)->find($request->request->get("Gerant_age"));
                        if (isset($gerantAge)) {
                            $infoClientGerant->setAgeClient($gerantAge ?? $infoClientGerant->getAgeClient()); //obj
                        }
                    }
                    $this->em->persist($infoClientGerant);
                    $this->em->flush();
                }
            }

            // Update Operateur
            if ($request->request->get("Operateur_nom") or $request->request->get("Operateur_telephone")) {
                //
                $infoClientOperateur = $this->em->getRepository(InfoClient::class)->findOneBy([
                    "client" => $existClient,
                    "typeClientNew" => self::OPERATEUR_ID
                ]);
                if ($infoClientOperateur) {
                    if ($request->request->get("Operateur_nom")) {
                        $infoClientOperateur->setNom($request->request->get("Operateur_nom"));
                    }
                    if ($request->request->get("Operateur_telephone")) {
                        $infoClientOperateur->setTelephone($request->request->get("Operateur_telephone"));
                    }
                    $typeOperateurClient = $this->em->getRepository(TypeClient::class)->find(self::OPERATEUR_ID); //  3:Operateur
                    if (isset($typeOperateurClient)) {
                        $infoClientOperateur->setTypeClientNew($typeOperateurClient);
                    }
                    $this->em->persist($infoClientOperateur);
                    $this->em->flush();
                }
            }

            /*************** Photos (4)**********************/

            $fileUploader = new  FileUploader($this->getParameter('images_pos_directory'));
            if ($request->files->get('image_licence')) {
                $this->removeOldClientImage($existClient, self::IMAGE_LICENCE_CLASSMENT);
                $uplodedImage = $request->files->get('image_licence');
                $fileName = $fileUploader->upload($uplodedImage);
                $pathLicencePhoto = '/uploads/pos/' . $fileName;
                $this->saveImageFile($fileName, $pathLicencePhoto, self::IMAGE_LICENCE_CLASSMENT, $existClient);
            }

            // Titulaire Image
            if ($request->files->get('image_titulaire')) {
                $this->removeOldClientImage($existClient, self::IMAGE_TITULAIRE_CLASSMENT);
                $uplodedImage = $request->files->get('image_titulaire');
                $fileName = $fileUploader->upload($uplodedImage);
                $pathLicencePhoto = '/uploads/pos/' . $fileName;

                $this->saveImageFile($fileName, $pathLicencePhoto, self::IMAGE_TITULAIRE_CLASSMENT, $existClient);
            }

            // Gerant Image
            if ($request->files->get('image_gerant')) {
                $this->removeOldClientImage($existClient, self::IMAGE_GERANT_CLASSMENT);
                $uplodedImage = $request->files->get('image_gerant');
                $fileName = $fileUploader->upload($uplodedImage);
                $pathLicencePhoto = '/uploads/pos/' . $fileName;
                $this->saveImageFile($fileName, $pathLicencePhoto, self::IMAGE_GERANT_CLASSMENT, $existClient);
            }

            // Operateur Image
            if ($request->files->get('image_operateur')) {
                $this->removeOldClientImage($existClient, self::IMAGE_OPERATEUR_CLASSMENT);
                $uplodedImage = $request->files->get('image_operateur');
                $fileName = $fileUploader->upload($uplodedImage);
                $pathLicencePhoto = '/uploads/pos/' . $fileName;
                $this->saveImageFile($fileName, $pathLicencePhoto, self::IMAGE_OPERATEUR_CLASSMENT, $existClient);
            }

            $this->em->flush();
            $data = $this->reternDataToShowInBo($existClient);
            if ($data) {
                return $this->successResponse($data);
            } else {
                return $this->successResponse(["code" => 204, "message" => "No Content"]);
            }
        }


    }

    /**
     * @Rest\Delete("/client/{id}/delete",name="client_bo_delete")
     */
    public
    function delete(
        Request $request,
        int $id
    ) {
        $client = $this->em->getRepository(Client::class)->find($id);
        if (isset($client)) {
            if ($client->getFile()) {
                // unlink images from folder
                $folder = $this->getParameter('images_pos_directory');
                $this->unlinkImages($client, $folder);
                $files = $client->getFile();
                if (!empty($files)) {
                    foreach ($files as $file) {
                        // Delete Files from database
                        $this->em->remove($file);
                        $this->em->flush();
                    }
                }
            }
            $this->em->remove($client);
            $this->em->flush();
            return $this->successResponse(["code" => 200, "message" => "Client Deleted"]);
        }
    }


    /***** upload csv clients with routings *****/
    /**
     * Upload Csv data (code -titulaire nom- code routing) attributes
     *
     * @Rest\Post("/clients/upload/csv", name="clientbo_upload_csv")
     * @return Response
     * @throws \League\Csv\Exception
     */
    public
    function uploadCsv(
        Request $request
    ) {
        $uplodedCsvFile = $request->files->get('file');
        $csvName = $uplodedCsvFile->getClientOriginalName();
        $typeFile = explode('.', $csvName)[1];
        if ($typeFile !== "csv") {
            return $this->successResponse(["code" => 409, "message" => "Please Uploded CSV File (.csv)"]);
        }

        $fileUploader = new  FileUploader($this->getParameter('csv_data_upload_directory'));
        $fileName = $fileUploader->upload($uplodedCsvFile);
        $filePath = $this->getParameter('csv_data_upload_directory') . '/' . $fileName;

        //Test static file :$filePath = $this->getParameter('csv_data_upload_directory').'/rows10.csv';
        //load the CSV document from a stream
        $stream = fopen($filePath, 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setHeaderOffset(0);

        //query your records from the document
        $records = $csv->getRecords();
        foreach ($records as $key => $record) {
            if (!isset($record["CodeClient"]) or !isset($record["TitulaireNom"]) or !isset($record["CodeRouting"])) {
                return $this->successResponse([
                    "code" => 409,
                    "message" => "Check Titles :: Must  like (CodeClient) (TitulaireNom) (CodeRouting)"
                ]);
            }
            $clientCode = $record["CodeClient"];
            $name = $record["TitulaireNom"];
            $routingCode = $record["CodeRouting"];

            // The format of Routing Code Like  "B-10-Ariana"
            $regxCodeRouting = '/^[A-B]{1}-[0-9]{2}-[a-zA-Z0-9\ _]*$/';
            //The format of Client Code must be integer of 1 into 5 digits {1}=>{99999}
            $regxClientCode = '/^\d{1,5}$/';

            // Test if format routing code is correct
            if (preg_match($regxCodeRouting, $routingCode)) {
                if (!preg_match($regxClientCode, $clientCode)) {
                    $errorInCodeClient[] = [
                        "ligne" => $key + 1,
                        "CodeClient" => $clientCode,
                        "TitulaireNom" => $name,
                        "CodeRouting" => $routingCode,
                        "Comment" => "Code must be < 99999, Between 1 and 99999 "
                    ];
                } else {


                    //$data[]=["ligne"=>$key+1,"CodeClient"=>$clientCode,"TitulaireNom"=>$name,"CodeRouting"=>$routingCode];

                    //Check if Client Exist in database by the ClientCode and not draft(=0)
                    $existClient = $this->em->getRepository(Client::class)->findOneBy([
                        "codeClient" => $clientCode,
                        "draft" => 0
                    ]);

                    // If client exist in the database
                    if (isset($existClient)) {
                        $redundancy[] = [
                            "ligne" => $key + 1,
                            "CodeClient" => $clientCode,
                            "TitulaireNom" => $name,
                            "CodeRouting" => $routingCode
                        ];

                        // Get The info Client by clientId and titulaire Id
                        $infoClient = $this->em->getRepository(InfoClient::class)->findOneBy([
                            "client" => $existClient->getId(),
                            "typeClientNew" => self::TITULAIRE_ID
                        ]);
                        //If Info Client Exist update name (nom titulaire)
                        if (isset($infoClient)) {
                            $infoClient->setNom($name);
                            $this->em->persist($infoClient);
                            $this->em->flush();
                        } else {
                            // Create New Info Client
                            $this->createInfoClient($existClient, $name);
                        }
                        //check if routing exist else create one + add  to the new client
                        $routingObject = $this->checkExistOrCreateRouting($routingCode);
                        if (isset($routingObject)) {
                            // update number POS
                            $routingObject->setNbrsPdv($routingObject->getNbrsPdv() + 1);
                            $existClient->addRouting($routingObject);
                        }
                        $this->em->persist($existClient);
                        $this->em->flush();

                    } else {
                        // Create new client if not exist
                        $newClient = $this->createClient($clientCode);

                        // Create info client set( titulaire nom)
                        $this->createInfoClient($newClient, $name);

                        //check if routing exist else create one  add  to the new client
                        $routingObject = $this->checkExistOrCreateRouting($routingCode);
                        if (isset($routingObject)) {
                            // update number POS
                            $routingObject->setNbrsPdv($routingObject->getNbrsPdv() + 1);
                            $newClient->addRouting($routingObject);
                        }
                        $this->em->persist($newClient);
                        $this->em->flush();
                    }


                }// of regx code Client
                // Else (if the routing code with rong format) return the ligne of error
            } else {
                $errors[] = [
                    "ligne" => $key + 1,
                    "CodeClient" => $clientCode,
                    "TitulaireNom" => $name,
                    "CodeRouting" => $routingCode,
                    "comment" => "The format of CodeRouting must be like (A-10-Ariana) or (A-10-Ariana Nord)"
                ];
            }
        }

        // Response
        if (empty($errors)) {
            $errors[] = null;
        }
        if (empty($redundancy)) {
            $redundancy[] = null;
        }
        if (empty($errorInCodeClient)) {
            $errorInCodeClient[] = null;
        }
        // Delete the csv file from folder after saving the data into Database
        unlink($filePath);

        return $this->successResponse([
            "code" => 200,
            "message" => "Client CSV Uploded",
            "errorsInRoutingCode" => $errors,
            "errorsInClientCode" => $errorInCodeClient,
            "redundancy" => $redundancy
        ]);

    }

    /**
     * check if routing exist else create one
     * @param $routingCode
     * @return Routing|object|null
     */
    private
    function checkExistOrCreateRouting(
        $routingCode
    ) {
        $array = explode("-", $routingCode);
        $classe = $array[0];
        $code = $array[1];
        $ville = $array[2];

        // Check if the routing exist
        $routingObject = $this->em->getRepository(Routing::class)->findOneBy([
            "classe" => $classe,
            "codeRouting" => $code,
            "ville" => $ville
        ]);

        //If routing exist
        if (isset($routingObject)) {
            // return the routing object
            $object = $routingObject;
        } else {
            // Create new Routing
            $newRouting = $this->createRouting($classe, $code, $ville);
            $object = $newRouting;
        }
        return $object;
    }

    /**
     * Create Client from csv(codeClient)
     * @param $clientCode
     * @return Client
     */
    private
    function createClient(
        $clientCode
    ) {
        $newClient = new Client();
        $newClient->setCodeClient($clientCode);
        $newClient->setDraft(0);
        $this->em->persist($newClient);
        $this->em->flush();
        return $newClient;
    }

    /**
     * Create Info Client from csv (nom titulaire)
     * type titulaire (titulaire with id = 1)
     * @param Client $newClient
     * @param string $name
     */
    private
    function createInfoClient(
        Client $newClient,
        string $name
    ) {
        $infoClient = new InfoClient();
        $typeClientObject = $this->em->getRepository(TypeClient::class)->find(self::TITULAIRE_ID);
        $infoClient->setClient($newClient);
        $infoClient->setNom($name);
        $infoClient->setTypeClientNew($typeClientObject);
        $this->em->persist($infoClient);
        $this->em->flush();
    }

    /**
     * Create Routing (classe,code,ville)
     * @param $classe
     * @param $code
     * @param $ville
     * @return Routing
     */
    private
    function createRouting(
        $classe,
        $code,
        $ville
    ) {
        $newRouting = new Routing();
        $newRouting->setClasse($classe);
        $newRouting->setCodeRouting($code);
        $newRouting->setVille($ville);
        $this->em->persist($newRouting);
        $this->em->flush();
        return $newRouting;
    }

    /**
     * Function to check if the routing is already added for the Client Or not
     * if yes , we increment the number of pos in the Routing entity
     * @param Client|null $existClient
     * @param int $id
     * @return bool
     */
    private
    function checkIfClientRoutingExist(
        ?Client $existClient,
        int $id
    ) {
        if ($existClient->getRoutings()) {
            $routingsIds = $existClient->getRoutings();

            if (!empty($routingsIds)) {
                foreach ($routingsIds as $routingsId) {
                    $routings[] = $routingsId->getId();
                }
            }
        }
        if (!empty($routings)) {

            if (in_array($id, $routings)) {
                return $id;
            } else {
                return false;
            }
        }
    }

    /**
     * @param Client|null $existClient
     */
    private
    function removeExistRoutings(
        ?Client $existClient
    ) {
        // Get all the ids of exist routing
        if ($existClient->getRoutings()) {
            //$existClient->removeRouting();
            $routingsObject = $existClient->getRoutings();
            if (!empty($routingsObject)) {
                foreach ($routingsObject as $routingObject) {
                    $existClient->removeRouting($routingObject);
                    $routingObject->setNbrsPdv($routingObject->getNbrsPdv() - 1);
                    $this->em->persist($routingObject);
                    $this->em->persist($existClient);
                    $this->em->flush();

                }
            }
        }
    }

    /**
     * @param Client|null $existClient
     * @param $routingsIdNew
     */
    private
    function cleanRoutingClient(
        ?Client $existClient,
        $routingsIdNew
    ) {
        // Get all the ids of exist routing
        if ($existClient->getRoutings()) {
            $routingsIdsExist = $existClient->getRoutings();
            if (!empty($routingsIdsExist)) {
                foreach ($routingsIdsExist as $routingsIdExist) {
                    $routingsExist[] = $routingsIdExist->getId();
                }
            } else {
                $routingsExist = null;
            }
        }
        // Get all the ids of new routing
        if (!empty($routingsIdNew)) {
            foreach ($routingsIdNew as $routingsIdNew) {
                $routingsNew[] = $routingsIdNew["id"];
            }
        } else {
            $routingsNew = null;
        }
        /*
          Check different value in two arrays and remove relation between
          client routing than unincriment the number of pos in Routing
         */
        $result = array_diff($routingsExist, $routingsNew);
        if (!empty($result)) {
            foreach ($result as $routing) {
                $routingObject = $this->em->getRepository(Routing::class)->find($routing);
                $existClient->removeRouting($routingObject);
                $routingObject->setNbrsPdv($routingObject->getNbrsPdv() - 1);
                $this->em->flush();
            }
        }
    }

    /**
     * Save File Into Database
     * @param string $fileName
     * @param string $pathImage
     * @param int $order
     * @param Client $client
     */
    private function saveImageFile(
        string $fileName,
        string $pathImage,
        int $order,
        Client $client
    ) {
        $file = new File();
        $file->setLabel($fileName);
        $file->setPath($pathImage);
        $file->setClassment($order);
        $this->em->persist($file);
        $this->em->flush();
        $file->setClient($client);
    }


    /**
     * Replace The Exisiting Image File of Client
     * @param $arrayImage
     * @param int $order
     * @param FileUploader $fileUploader
     */
    private function saveNewImageWhenUpdate(
        $data,
        int $order,
        FileUploader $fileUploader
    ) {
        $folder = $this->getParameter('images_pos_directory');
        $idImageLicence = (int)$data->getId();
        $uplodedImage = $data->getFile();
        // Get the image object by id(int) and classment(int)
        $existImage = $this->em->getRepository(File::class)->findOneBy([
            "id" => $idImageLicence,
            "classment" => $order
        ]);

        if ($existImage) {
            // Delete Image from folder
            $paths = $folder . '/' . $existImage->getLabel();
            unlink($paths);
            // Update the new image file
            $fileName = $fileUploader->upload($uplodedImage);
            $path = '/uploads/pos/' . $fileName;
            $existImage->setPath($path);
            $existImage->setLabel($fileName);
            $this->em->persist($existImage);
            $this->em->flush();
        }
    }

    /**
     * This function is for return the object after create or after update for The BO
     * @param $client
     * @return array
     */
    private
    function reternDataToShowInBo(
        $client
    ) {
        // Nom Titulaire
        $titulaireObject = $this->em->getRepository(InfoClient::class)->findOneBy([
            "client" => $client->getId(),
            "typeClientNew" => self::TITULAIRE_ID
        ]);
        // Routings
        $routings = $this->em->getRepository(Client::class)->findAllRoutings($client->getId());
        if (isset($routings)) {
            $allRoutings = $routings;
        } else {
            $allRoutings = null;
        }
        //Merch
        if ($client->getMerchId()) {
            $merchObject = $this->em->getRepository(Merch::class)->find($client->getMerchId());
            if (isset($merchObject)) {
                $merchCode = $merchObject->getCode() . '-' . $merchObject->getFirstName() . ' ' . $merchObject->getLastName();
                $merchId = $merchObject->getId();
                $merch = ["id" => $merchId, "label" => $merchCode];
            } else {
                $merch = "-";
            }
        }

        // Data to show
        $data[] = array(
            "id" => $client->getId(),
            "codeClient" => $client->getCodeClient(),
            "nomTitulaire" => $titulaireObject->getNom(),
            "ville" => $client->getVille() ?? null,
            "nombreAffectation" => $client->getNmbAffectation(),
            "merch" => $merch ?? null,
            "routings" => $allRoutings
        );
        return $data;
    }

    /**
     * Remove and unlink image of client when update
     * @param Client|null $existClient
     * @param int $int
     */
    private function removeOldClientImage(?Client $existClient, int $int)
    {
        $oldImage = $this->em->getRepository(File::class)->findOneBy([
            "client" => $existClient->getId(),
            "classment" => $int
        ]);
        if ($oldImage) {
            // unlink images from folder
            $folder = $this->getParameter('images_pos_directory');
            $path = $folder . '/' . $oldImage->getLabel();
            unlink($path);
            $this->em->remove($oldImage);
            $this->em->flush();
        }
    }


}
