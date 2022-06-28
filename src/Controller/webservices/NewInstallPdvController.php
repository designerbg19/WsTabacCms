<?php

namespace App\Controller\webservices;

use App\Entity\Age;
use App\Entity\Client;
use App\Entity\InfoClient;
use App\Entity\ListInstallPdv;
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
use App\Entity\PdvTypesQuartier;
use App\Entity\PdvTypologies;
use App\Entity\PdvVisibilite;
use App\Entity\Quartier;
use App\Entity\Routing;
use App\Entity\SituationFamilialle;
use App\Entity\TypeClient;
use App\Service\FileUploader;
use App\Entity\NewInstallPdv;
use App\Entity\NewInstallPdvComments;
use App\Entity\PdvSuperficie;
use App\Entity\Region;
use DateTime;
use mysql_xdevapi\Result;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class NewInstallPdvController extends MainController
{
    /**
     * @Rest\Get("/newinstallpdv/showall", name="new_install_pdv_show_all")
     * @return Response
     * @throws \Exception
     */
    public function index()
    {
        $data = $this->allNewInstallPdv();
        if (isset($data)) {
            return $this->successResponse($data);
        } else {
            return $this->successResponse(["code" => 204, "message" => "No Content"]);
        }
    }

    /**
     * @Rest\Get("/newinstallpdv/showallpagination", name="new_install_pdv_show_all_with_pagination")
     * @return Response
     * @throws \Exception
     */
    public function findNewInstallPdvWithPagination(Request $request)
    {

        $data = $this->allNewInstallPdv();
        if (!empty($data)) {
            $pagination = $this->paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                self::NUMBER_ITEM_PER_PAGE
            );
            return $this->successResponse($pagination);
        } else {
            return $this->successResponse(["code" => 204, "message" => "No Content"]);
        }
    }


    /**
     * @Rest\Get("/newinstallpdv/{id}", name="new_install_pdv_show_by_id")
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $newInstallPdv = $this->em->getRepository(NewInstallPdv::class)->find($id);
        if (isset($newInstallPdv)) {
            return $this->successResponse($newInstallPdv);
        }
    }


    /**
     * Show detail client by code for iPad Part (when create new pdv install )
     * @Rest\Get("/newinstallpdv/client/{code}/code", name="show_client_by_code")
     * @param int $code
     *
     * @return Response
     */
    public function showDetailClientByCode(int $code)
    {
        $client = $this->em->getRepository(Client::class)->findOneBy(["codeClient" => $code]);
        if (isset($client)) {
            $result = $this->showDetailClientById($client->getId());
            return $result;
        } else {
            return $this->successResponse(["code" => 204, "message" => "No Content"]);
        }
    }

    /**
     * Show client autocompleate for iPad Part (when create new pdv install )
     * @Rest\Get("/newinstallpdv/client/autocomplete/{code}", name="show_client_by_code_autocomplete")
     * @param int $code
     *
     * @return Response
     */
    public function showDetailClientAutocompleate(int $code)
    {
        $client = $this->em->getRepository(Client::class)->findClientsAutoComplete($code);
        if (isset($client)) {
            return $this->successResponse(["code" => 200, "message" => "succes", "clients" => $client]);
        } else {
            return $this->successResponse(["code" => 204, "message" => "No Content"]);
        }
    }

    /**
     * Function to show client by id for (iPad)
     * @param $id
     * @return Response id of Survey
     */
    private function showDetailClientById($id)
    {
        $result = $this->forward('App\Controller\webservices\ClientController::showinfoPDV', [
            'id' => $id,
        ]);
        return $result;
    }

    /**
     * Created From (iPad) Part
     * @Rest\Post("/newinstallpdv/create", name="new_install_pdv_create")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $jsonData = json_decode($request->getContent(), true);

        $newInstallPdv = new NewInstallPdv();
        $newInstallPdv->setStatusNewInstall(0);
        $newInstallPdv->setVisibility(1); // default Value visiball
        $newInstallPdv->setCin($jsonData["cin"]);

        /***** Info Client ********/
        $newInstallPdv->setMerchId($jsonData["merch_id"]);
        if (isset($jsonData["code_client"])) {
            $newInstallPdv->setCodeClient($jsonData["code_client"]);
        }
        $newInstallPdv->setLicence($jsonData["licence"]);
        $newInstallPdv->setDecideurId($jsonData["decideur_id"]);
        $newInstallPdv->setLongitude($jsonData["longitude"]);
        $newInstallPdv->setLatitude($jsonData["latitude"]);


        /***** Type Info Client ********/

        //Titulaire
        $newInstallPdv->setTitulairenom($jsonData["Titulaire_nom"]);
        $newInstallPdv->setTitulairetel($jsonData["Titulaire_telephone"]);
        $newInstallPdv->setTitulairesituationId($jsonData["Titulaire_situationFamil_id"]);
        $newInstallPdv->setTitulairenbrenfId($jsonData["Titulaire_nbrEnfant_id"]);
        $newInstallPdv->setTitulaireageId($jsonData["Titulaire_AgeClient_id"]);

        //Gerant
        $newInstallPdv->setGerantnom($jsonData["Gerant_nom"]);
        $newInstallPdv->setGeranttel($jsonData["Gerant_telephone"]);
        $newInstallPdv->setGerantsituationId($jsonData["Gerant_situationFamil_id"]);
        $newInstallPdv->setGerantnbrenfId($jsonData["Gerant_nbrEnfant_id"]);
        $newInstallPdv->setGerantageId($jsonData["Gerant_AgeClient_id"]);

        //Operateur
        $newInstallPdv->setOperateurnom($jsonData["Operateur_nom"]);
        $newInstallPdv->setOperateurtel($jsonData["Operateur_telephone"]);


        /***** Info PDV ********/
        $newInstallPdv->setRegionId($jsonData["region_id"]);
        $newInstallPdv->setZoneId($jsonData["zone_id"]);
        $newInstallPdv->setGouvernoratId($jsonData["gouvernorat_id"]);
        $newInstallPdv->setDelegationId($jsonData["deligation_id"]);
        $newInstallPdv->setQuartierId($jsonData["quartier_id"]);
        $newInstallPdv->setAdress($jsonData["address"]);
        $newInstallPdv->setCodePostal($jsonData["code_postal"]);
        $newInstallPdv->setSuperficieId($jsonData["superficie_id"]);
        $newInstallPdv->setNbremployesId($jsonData["nbremployer_id"]);
        $newInstallPdv->setEmplacementId($jsonData["emplacement_id"]);
        $newInstallPdv->setEnvironnementId($jsonData["envirenement_id"]);
        $newInstallPdv->setTypequartierId($jsonData["typeDeQuartier_id"]);
        $newInstallPdv->setVisibiliteId($jsonData["visibiliter_id"]);
        $newInstallPdv->setClasseId($jsonData["classe_id"]);
        $newInstallPdv->setTypologieId($jsonData["typologie_id"]);
        $newInstallPdv->setIsAccessPdv($jsonData["is_acces_pdv"]);
        $newInstallPdv->setPresentoirJtiId($jsonData["presentoire_id"]);

        /***** Info Marketing ********/
        $newInstallPdv->setIsOnetoone($jsonData["is_onetoone"]);
        $newInstallPdv->setRegieTabacId($jsonData["regie_tabac_id"]);
        $newInstallPdv->setRecetteprincipalId($jsonData["rectteP_id"]);
        $newInstallPdv->setRecettescecondaireId($jsonData["rectteS_id"]);
        $newInstallPdv->setIsTlp($jsonData["is_tlp"]);
        $newInstallPdv->setIsFsPotentiel($jsonData["is_fs_potentiel"]);
        $newInstallPdv->setCompagneId($jsonData["Compagne_en_cour_id"]);

        /***** Stock Min ********/
        $newInstallPdv->setMinStock($jsonData["stokeArray"]);
        /********** PLV (install jti - shop program/ uninstall not Jti) Array **************************/
        $newInstallPdv->setPlv($jsonData["plv"]);

        $newInstallPdv->setComment($jsonData["comment"]);
        $newInstallPdv->setCommentPlv($jsonData["commentPlv"]);
        $this->em->persist($newInstallPdv);
        $this->em->flush();

        // Create List Install PDV
        $listInstallPdv = new ListInstallPdv();
        $listInstallPdv->setNewInstallId($newInstallPdv->getId());
        $listInstallPdv->setMerchId($jsonData["merch_id"]);
        $listInstallPdv->setTitulaireNom($newInstallPdv->getTitulairenom());
        $listInstallPdv->setGouvernoratId($jsonData["gouvernorat_id"]);
        $listInstallPdv->setQuartierId($jsonData["quartier_id"]);
        $listInstallPdv->setStatusNewInstall($newInstallPdv->getStatusNewInstall());
        $this->em->persist($listInstallPdv);
        $this->em->flush();

        return $this->successResponse([
            "code" => 200,
            "message" => "New Install POS Created",
            "installId" => $newInstallPdv->getId()
        ]);
    }


    /**
     * Update  From (BO) Part
     * @Rest\Post("/newinstallpdv/{id}/update/accept", name="new_install_pdv_update_accept")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function update(Request $request, int $id)
    {
        $jsonData = json_decode($request->getContent(), true);

        $newInstallPdv = $this->em->getRepository(NewInstallPdv::class)->find($id);
        $newInstallPdv->setStatusNewInstall(0);
        $newInstallPdv->setVisibility(1); // default Value visiball
        $newInstallPdv->setCin($jsonData["cin"] ?? $newInstallPdv->getCin());

        /***** Info Client ********/
        $newInstallPdv->setMerchId($jsonData["merch_id"] ?? $newInstallPdv->getMerchId());
        if (isset($jsonData["code_client"])) {
            $newInstallPdv->setCodeClient($jsonData["code_client"] ?? $newInstallPdv->getCodeClient());
        } else {
            return $this->successResponse(["code" => 204, "message" => "Code Client Not Defined"]);
        }

        $newInstallPdv->setLicence($jsonData["licence"] ?? $newInstallPdv->getLicence());
        $newInstallPdv->setDecideurId($jsonData["decideur_id"] ?? $newInstallPdv->getDecideurId());
        $newInstallPdv->setLongitude($jsonData["longitude"] ?? $newInstallPdv->getLongitude());
        $newInstallPdv->setLatitude($jsonData["latitude"] ?? $newInstallPdv->getLatitude());


        /***** Type Info Client ********/

        //Titulaire
        $newInstallPdv->setTitulairenom($jsonData["Titulaire_nom"] ?? $newInstallPdv->getTitulairenom());
        $newInstallPdv->setTitulairetel($jsonData["Titulaire_telephone"] ?? $newInstallPdv->getTitulairetel());
        $newInstallPdv->setTitulairesituationId($jsonData["Titulaire_situationFamil_id"] ?? $newInstallPdv->getTitulairesituationId());
        $newInstallPdv->setTitulairenbrenfId($jsonData["Titulaire_nbrEnfant_id"] ?? $newInstallPdv->getTitulairenbrenfId());
        $newInstallPdv->setTitulaireageId($jsonData["Titulaire_AgeClient_id"] ?? $newInstallPdv->getTitulaireageId());

        //Gerant
        $newInstallPdv->setGerantnom($jsonData["Gerant_nom"] ?? $newInstallPdv->getGerantnom());
        $newInstallPdv->setGeranttel($jsonData["Gerant_telephone"] ?? $newInstallPdv->getGeranttel());
        $newInstallPdv->setGerantsituationId($jsonData["Gerant_situationFamil_id"] ?? $newInstallPdv->getGerantsituationId());
        $newInstallPdv->setGerantnbrenfId($jsonData["Gerant_nbrEnfant_id"] ?? $newInstallPdv->getGerantnbrenfId());
        $newInstallPdv->setGerantageId($jsonData["Gerant_AgeClient_id"] ?? $newInstallPdv->getGerantageId());

        //Operateur
        $newInstallPdv->setOperateurnom($jsonData["Operateur_nom"] ?? $newInstallPdv->getOperateurnom());
        $newInstallPdv->setOperateurtel($jsonData["Operateur_telephone"] ?? $newInstallPdv->getOperateurtel());


        /***** Info PDV ********/
        $newInstallPdv->setRegionId($jsonData["region_id"] ?? $newInstallPdv->getRegionId());
        $newInstallPdv->setZoneId($jsonData["zone_id"] ?? $newInstallPdv->getZoneId());
        $newInstallPdv->setGouvernoratId($jsonData["gouvernorat_id"] ?? $newInstallPdv->getGouvernoratId());
        $newInstallPdv->setDelegationId($jsonData["deligation_id"] ?? $newInstallPdv->getDelegationId());
        $newInstallPdv->setQuartierId($jsonData["quartier_id"] ?? $newInstallPdv->getQuartierId());
        $newInstallPdv->setAdress($jsonData["address"] ?? $newInstallPdv->getAdress());
        $newInstallPdv->setCodePostal($jsonData["code_postal"] ?? $newInstallPdv->getCodePostal());
        $newInstallPdv->setSuperficieId($jsonData["superficie_id"] ?? $newInstallPdv->getSuperficieId());
        $newInstallPdv->setNbremployesId($jsonData["nbremployer_id"] ?? $newInstallPdv->getNbremployesId());
        $newInstallPdv->setEmplacementId($jsonData["emplacement_id"] ?? $newInstallPdv->getEmplacementId());
        $newInstallPdv->setEnvironnementId($jsonData["envirenement_id"] ?? $newInstallPdv->getEnvironnementId());
        $newInstallPdv->setTypequartierId($jsonData["typeDeQuartier_id"] ?? $newInstallPdv->getTypequartierId());
        $newInstallPdv->setVisibiliteId($jsonData["visibiliter_id"] ?? $newInstallPdv->getVisibiliteId());
        $newInstallPdv->setClasseId($jsonData["classe_id"] ?? $newInstallPdv->getClasseId());
        $newInstallPdv->setTypologieId($jsonData["typologie_id"] ?? $newInstallPdv->getTypologieId());
        $newInstallPdv->setIsAccessPdv($jsonData["is_acces_pdv"] ?? $newInstallPdv->getIsAccessPdv());
        $newInstallPdv->setPresentoirJtiId($jsonData["presentoire_id"] ?? $newInstallPdv->getPresentoirJtiId());

        /***** Info Marketing ********/
        $newInstallPdv->setIsOnetoone($jsonData["is_onetoone"] ?? $newInstallPdv->getIsOnetoone());
        $newInstallPdv->setRegieTabacId($jsonData["regie_tabac_id"] ?? $newInstallPdv->getRegieTabacId());
        $newInstallPdv->setRecetteprincipalId($jsonData["rectteP_id"] ?? $newInstallPdv->getRecetteprincipalId());
        $newInstallPdv->setRecettescecondaireId($jsonData["rectteS_id"] ?? $newInstallPdv->getRecettescecondaireId());
        $newInstallPdv->setIsTlp($jsonData["is_tlp"] ?? $newInstallPdv->getIsTlp());
        $newInstallPdv->setIsFsPotentiel($jsonData["is_fs_potentiel"] ?? $newInstallPdv->getIsFsPotentiel());
        $newInstallPdv->setCompagneId($jsonData["Compagne_en_cour_id"] ?? $newInstallPdv->getCompagneId());

        /***** Stock Min ********/
        $newInstallPdv->setMinStock($jsonData["stokeArray"] ?? $newInstallPdv->getMinStock());

        /********** PLV (install jti - shop program/ uninstall not Jti) Array **************************/
        $newInstallPdv->setPlv($jsonData["plv"] ?? $newInstallPdv->getPlv());

        /***** Add Routings ********/
        $newInstallPdv->setRoutings($jsonData["routings"]);

        $newInstallPdv->setCommentPlv($jsonData["commentPlv"] ?? $newInstallPdv->getCommentPlv());


        $newInstallPdv->setComment($newInstallPdv->getComment());
        $this->em->persist($newInstallPdv);
        $this->em->flush();

        // update List Install PDV
        $listInstallPdv = $this->em->getRepository(ListInstallPdv::class)->findOneBy(["newInstallId" => $id]);
        $listInstallPdv->setTitulaireNom($newInstallPdv->getTitulairenom());
        $listInstallPdv->setGouvernoratId($listInstallPdv->getGouvernoratId());
        $listInstallPdv->setQuartierId($listInstallPdv->getQuartierId());
        $listInstallPdv->setStatusNewInstall($newInstallPdv->getStatusNewInstall());
        $listInstallPdv->setMerchId($newInstallPdv->getMerchId());
        $this->em->persist($listInstallPdv);
        $this->em->flush();

        //return $this->successResponse(["code"=>201,"message"=>"Updated"]);
        $this->save($id, $request);
        return $this->successResponse(["code" => 200, "message" => "New Install Accepted"]);
    }


    /**
     * save as a client From (BO) Part
     * @Rest\Post("/newinstallpdv/{id}/save", name="new_install_pdv_save")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function save(int $id, Request $request)
    {
        //change the status of the (iPad) part
        $this->statusOfAdmin($id, 1, 0, 1);
        //saved to database
        $newInstallPdv = $this->em->getRepository(NewInstallPdv::class)->find($id);
        if ($newInstallPdv) {
            $codeClient = $newInstallPdv->getCodeClient();
            $existClient = $this->em->getRepository(Client::class)->findOneBy(["codeClient" => $codeClient]);
            if ($existClient) {
                // update client
                $this->setAllAtributesOfClient($existClient, $newInstallPdv, false);
                return $this->successResponse([
                    "code" => 201,
                    "message" => "Client Updated",
                    "clientId" => $existClient->getId()
                ]);
            } else {
                // create new Client
                $newClient = new Client();
                $this->setAllAtributesOfClient($newClient, $newInstallPdv, true);
                return $this->successResponse(["code" => 200, "message" => "Client Created"]);
            }
        }

    }


    /**
     * @Rest\Delete("/newinstallpdv/{id}/delete", name="new_install_pdv_delete")
     * Function to delete New Install From db when Refus Admin
     */
    public function delete(int $id)
    {
        $newInstallPdv = $this->em->getRepository(NewInstallPdv::class)->find($id);
        if (isset($newInstallPdv)) {
            $this->em->remove($newInstallPdv);
            $this->em->flush();
        }
        return $this->successResponse(["code" => 200, "message" => "Ok"]);
    }

    /*******************************************************************************************************/

    ///**
    //* Created From (iPad) Part
    //* @Rest\Post("/newinstallpdv/{id}/accept", name="new_install_pdv_accept")
    //* @param int $id
    //* @return Response
    //* @throws \Exception
    //*/
    /* public function accept(int $id,Request $request)
     {
         //$this->statusOfAdmin($id,1,0,1);
         // add new Install to database with  routing code and client code
         //$this->update($request, $id);
        // $this->save($id);
        // return $this->successResponse(["code"=>200,"message"=>"Accepted"]);
     }*/

    /**
     * Created From (iPad) Part
     * @Rest\Post("/newinstallpdv/{id}/refus", name="new_install_pdv_refus")
     * @param int $id
     * @return Response
     */
    public function refus(int $id)
    {
        $this->statusOfAdmin($id, -1, 0, -1);
        // Delete New Install PDV From db
        $this->delete($id);
        return $this->successResponse(["code" => 200, "message" => "Refused"]);
    }


    /**
     *
     * @param int $id
     * @param int $statusNewInstallPdv
     * @param int $visibility
     * @param int $statusNewInstallInList
     */
    function statusOfAdmin(int $id, int $statusNewInstallPdv, int $visibility, int $statusNewInstallInList)
    {
        $newInstallPdv = $this->em->getRepository(NewInstallPdv::class)->find($id);
        $listInstallPdv = $this->em->getRepository(ListInstallPdv::class)->findOneBy(['newInstallId' => $id]);
        $newInstallPdv->setStatusNewInstall($statusNewInstallPdv);

        $newInstallPdv->setVisibility($visibility);
        $listInstallPdv->setStatusNewInstall($statusNewInstallInList);
        $this->em->flush();
    }

    /**
     *  Function To Calculate the number of days since the createion of new install PDV
     * @param $date
     * @return mixed
     * @throws \Exception
     */
    private function waitingSince($date)
    {
        $dateNow = new DateTime('NOW');
        $interval = $date->diff($dateNow);
        return $interval->format('%R%a jour(s)');
    }


    /**
     * Created From (BO) Part
     * @Rest\Post("/newinstallpdv/{id}/create/condition", name="new_install_pdv_condition")
     * @param int $id
     * @return Response
     */
    public function condition(Request $request, int $id)
    {
        $newInstallCommentsExist = $this->em->getRepository(NewInstallPdvComments::class)->findOneBy(['newInstallPdv' => $id]);

        $newInstallPdv = $this->em->getRepository(NewInstallPdv::class)->find($id);
        $listInstallPdv = $this->em->getRepository(ListInstallPdv::class)->findOneBy(['newInstallId' => $id]);
        $newInstallPdv->setStatusNewInstall(2);
        $listInstallPdv->setStatusNewInstall(2);
        // Hide the NewInstallPdv
        $newInstallPdv->setVisibility(0);
        $this->em->flush();

        if ($newInstallCommentsExist) {
            $newInstallCommentsExist->setComment($request->request->get("comment"));
            $uploadedImage = $request->files->get('image');
            if ($uploadedImage) {
                $fileUploader = new  FileUploader($this->getParameter('new_install_directory'));
                $imageName = $fileUploader->upload($uploadedImage);
                $path = '/uploads/newinstallpdv/' . $imageName;
                $newInstallCommentsExist->setModifiedImage($path);
            }
            $newInstallCommentsExist->setNewInstallPdv($newInstallCommentsExist->getNewInstallPdv());
            $newInstallCommentsExist->setMerchStatusComment(0); // default 0
            $this->em->persist($newInstallCommentsExist);
            $this->em->flush();
        } else {
            $newInstallPdvComments = new NewInstallPdvComments();
            $newInstallPdvComments->setComment($request->request->get("comment"));
            $newInstallPdvComments->setNewInstallPdv($newInstallPdv);
            $newInstallPdvComments->setMerchStatusComment(0); // default 0
            $this->em->persist($newInstallPdvComments);
            $this->em->flush();
        }

        return $this->successResponse(["code" => 200, "message" => "Comment Created"]);
    }


    /**
     * Custom Display all NewInstall Pdv for ( BO Part)
     * @return array|null
     * @throws \Exception
     */
    private function allNewInstallPdv()
    {
        $newInstallPdvAll = $this->em->getRepository(NewInstallPdv::class)->customFindAll();
        foreach ($newInstallPdvAll as $newInstall) {
            $merchObject = $this->em->getRepository(Merch::class)->find($newInstall["merchId"]);
            if (($merchObject->getRegion()) != null) {
                $regionMerchId = $merchObject->getRegion()->getId();
                $merchRegion = $this->em->getRepository(Region::class)->find($regionMerchId);
                $regionLabel = $merchRegion->getLabel();
            } else {
                $regionLabel = "-";
            }
            $waitingSince = $this->waitingSince($newInstall["newInstallDate"]);
            $data[] = array(
                "id" => $newInstall["id"],
                "merch" => $merchObject->getCode() . ' - ' . $merchObject->getFirstName() . ' ' . $merchObject->getLastName(),
                "region" => $regionLabel,
                "date" => $newInstall["newInstallDate"],
                "en_attente_depuis" => $waitingSince
            );
        }
        if (!empty($data)) {
            return $data;
        } else {
            return null;
        }
    }

    /**
     * @param Client $client
     * @param NewInstallPdv|null $newInstallPdv
     */
    private function setAllAtributesOfClient(Client $client, ?NewInstallPdv $newInstallPdv, bool $isCreate)
    {

        $deciderObject = $this->em->getRepository(TypeClient::class)->find($newInstallPdv->getDecideurId());
        $classeObject = $this->em->getRepository(PdvClasses::class)->find($newInstallPdv->getClasseId());
        $quartierObject = $this->em->getRepository(Quartier::class)->find($newInstallPdv->getQuartierId());
        $superficieObject = $this->em->getRepository(PdvSuperficie::class)->find($newInstallPdv->getSuperficieId());
        $nbrEmployeeObject = $this->em->getRepository(NbrEmployer::class)->find($newInstallPdv->getNbremployesId());
        $emplacementOject = $this->em->getRepository(PdvEmplacements::class)->find($newInstallPdv->getEmplacementId());
        $environnementObject = $this->em->getRepository(PdvEnvironnements::class)->find($newInstallPdv->getEnvironnementId());
        $typeQuartierObject = $this->em->getRepository(PdvTypesQuartier::class)->find($newInstallPdv->getTypequartierId());
        $visibiliteObject = $this->em->getRepository(PdvVisibilite::class)->find($newInstallPdv->getVisibiliteId());
        $topologieObject = $this->em->getRepository(PdvTypologies::class)->find($newInstallPdv->getTypologieId());
        $presentoireObject = $this->em->getRepository(PdvPresentoire::class)->find($newInstallPdv->getPresentoirJtiId());
        $regieTabacObject = $this->em->getRepository(MarketingRegieTabac::class)->find($newInstallPdv->getRegieTabacId());
        $recettePrincipObject = $this->em->getRepository(MarketingRecette::class)->find($newInstallPdv->getRecetteprincipalId());
        $recetteSecondObject = $this->em->getRepository(MarketingRecette::class)->find($newInstallPdv->getRecettescecondaireId());
        $companieOncourObject = $this->em->getRepository(MarketingCampagneEnCours::class)->find($newInstallPdv->getCompagneId());


        $client->setMerchId($newInstallPdv->getMerchId());
        $client->setLongitude($newInstallPdv->getLongitude());
        $client->setLatitude($newInstallPdv->getLatitude());
        $client->setCodeClient($newInstallPdv->getCodeClient());
        $client->setLicence($newInstallPdv->getLicence());
        $client->setAdress($newInstallPdv->getAdress());
        $client->setDecider($deciderObject);// obj
        $client->setCin($newInstallPdv->getCin());
        $client->setClasse($classeObject); //obj
        $client->setQuartier($quartierObject);//obj
        $client->setCodePostal($newInstallPdv->getCodePostal());
        $client->setSuperficie($superficieObject); //obj
        $client->setNbrEmplyer($nbrEmployeeObject); //obj
        $client->setEmplacement($emplacementOject); //obj
        $client->setEnvironnement($environnementObject); //
        $client->setTypeDeQuartier($typeQuartierObject);//obj
        $client->setVisibiliter($visibiliteObject);//obj
        $client->setTypologie($topologieObject);// obj
        $client->setInfoAccPdv($newInstallPdv->getIsAccessPdv()); // true/false
        $client->setPresentoire($presentoireObject);//obj
        $client->setIsOneToOne($newInstallPdv->getIsOnetoone());// true/false
        $client->setRegieTabac($regieTabacObject); //obj
        if ($recettePrincipObject) {
            $client->setRecetteP($newInstallPdv->getRecettescecondaireId());
        }
        if ($recetteSecondObject) {
            $client->setRecetteS($newInstallPdv->getRecettescecondaireId());
        }
        $client->setIsTlp($newInstallPdv->getIsTlp()); // true/false
        $client->setIsFsPotentiel($newInstallPdv->getIsFsPotentiel()); // true/false
        $client->setCompanieOncour($companieOncourObject); // obj

        $client->setDateInstalation(($newInstallPdv->getNewInstallDate())->format('Y-m-d H:i:s'));
        $client->setNmbAffectation(0);

        // check if the client has routings (if yes: remove and set the new routings) else set the same existing routing
        $existRoutings = $client->getRoutings();
        if ($existRoutings) {
            foreach ($existRoutings as $existRouting) {
                $client->removeRouting($existRouting);
            }
            $routingsId = $newInstallPdv->getRoutings();
            foreach ($routingsId as $routing) {
                $routingObject = $this->em->getRepository(Routing::class)->find($routing["id"]);
                $client->addRouting($routingObject);
            }
        } else {
            $client->addRouting($client->getRoutings());
        }

        $client->setDraft(0);

        $this->em->persist($client);
        $this->em->flush();


        /****** info Client entity ************/
        if ($isCreate == true) {
            // Create New Titulaire
            $infoClientTitulaire = new InfoClient();
            $typeTitulaireClient = $this->em->getRepository(TypeClient::class)->find(self::TITULAIRE_ID); //  1:Titulaire
            $infoClientTitulaire->setNom($newInstallPdv->getTitulairenom());
            $infoClientTitulaire->setTypeClientNew($typeTitulaireClient);
            $situationFamTitulaireObject = $this->em->getRepository(SituationFamilialle::class)->find($newInstallPdv->getTitulairesituationId());
            $infoClientTitulaire->setSituationFamil($situationFamTitulaireObject);
            $titulairetNbrEnfantsObject = $this->em->getRepository(NbrEnfant::class)->find($newInstallPdv->getTitulairenbrenfId());
            $infoClientTitulaire->setNbrEnfant($titulairetNbrEnfantsObject);
            $titulairetAgeObject = $this->em->getRepository(NbrEnfant::class)->find($newInstallPdv->getTitulaireageId());
            $infoClientTitulaire->setAgeClient($titulairetAgeObject);
            $infoClientTitulaire->setClient($client);
            $this->em->persist($infoClientTitulaire);
            $this->em->flush();
            // Create New Gerant
            $infoClientGerant = new InfoClient();
            $typeGerantClient = $this->em->getRepository(TypeClient::class)->find(self::GERANT_ID); //  2:Gerant
            $infoClientGerant->setNom($newInstallPdv->getGerantnom());
            $infoClientGerant->setTypeClientNew($typeGerantClient);
            $situationFamGerantObject = $this->em->getRepository(SituationFamilialle::class)->find($newInstallPdv->getGerantsituationId());
            $infoClientGerant->setSituationFamil($situationFamGerantObject);
            $GerantNbrEnfantsObject = $this->em->getRepository(NbrEnfant::class)->find($newInstallPdv->getGerantnbrenfId());
            $infoClientGerant->setNbrEnfant($GerantNbrEnfantsObject);
            $GerantAgeObject = $this->em->getRepository(NbrEnfant::class)->find($newInstallPdv->getGerantageId());
            $infoClientGerant->setAgeClient($GerantAgeObject);
            $infoClientGerant->setClient($client);
            $this->em->persist($infoClientGerant);
            $this->em->flush();
            // Create New Operateur
            $infoClientOperateur = new InfoClient();
            $typeOperateurClient = $this->em->getRepository(TypeClient::class)->find(self::OPERATEUR_ID); //  3:Operateur
            $infoClientOperateur->setNom($newInstallPdv->getOperateurnom());
            $infoClientOperateur->setTypeClientNew($typeOperateurClient);
            $infoClientOperateur->setTelephone($newInstallPdv->getOperateurtel());
            $infoClientOperateur->setClient($client);
            $this->em->persist($infoClientOperateur);
            $this->em->flush();
        }else{
            // Update Titulaire
                $infoClientTitulaire = $this->em->getRepository(InfoClient::class)->findOneBy([
                    "client" => $client,
                    "typeClientNew" => self::TITULAIRE_ID
                ]);
                if ($infoClientTitulaire) {
                        $infoClientTitulaire->setNom($newInstallPdv->getTitulairenom() ?? $infoClientTitulaire->getNom());
                        $infoClientTitulaire->setTelephone($newInstallPdv->getTitulairetel() ?? $infoClientTitulaire->getTelephone());
                        $titulaireSituationFam = $this->em->getRepository(SituationFamilialle::class)->find($newInstallPdv->getTitulairesituationId());
                        if (isset($titulaireSituationFam)) {
                            $infoClientTitulaire->setSituationFamil($titulaireSituationFam ?? $infoClientTitulaire->getSituationFamil());//obj
                        }
                        $titulairetNbrEnfants = $this->em->getRepository(NbrEnfant::class)->find($newInstallPdv->getTitulairenbrenfId());
                        if (isset($titulairetNbrEnfants)) {
                            $infoClientTitulaire->setNbrEnfant($titulairetNbrEnfants ?? $infoClientTitulaire->getNbrEnfant());//obj
                        }
                        $titulaireAge = $this->em->getRepository(Age::class)->find($newInstallPdv->getTitulaireageId());
                        if (isset($titulaireAge)) {
                            $infoClientTitulaire->setAgeClient($titulaireAge ?? $infoClientTitulaire->getAgeClient()); //obj
                        }
                    $this->em->persist($infoClientTitulaire);
                    $this->em->flush();
                }

            // Update Gerant
            $infoClientGerant = $this->em->getRepository(InfoClient::class)->findOneBy([
                "client" => $client,
                "typeClientNew" => self::GERANT_ID
            ]);
            if ($infoClientGerant) {
                $infoClientGerant->setNom($newInstallPdv->getTitulairenom() ?? $infoClientGerant->getNom());
                $infoClientGerant->setTelephone($newInstallPdv->getTitulairetel() ?? $infoClientGerant->getTelephone());
                $gerantSituationFam = $this->em->getRepository(SituationFamilialle::class)->find($newInstallPdv->getTitulairesituationId());
                if (isset($gerantSituationFam)) {
                    $infoClientGerant->setSituationFamil($gerantSituationFam ?? $infoClientGerant->getSituationFamil());//obj
                }
                $gerantNbrEnfants = $this->em->getRepository(NbrEnfant::class)->find($newInstallPdv->getTitulairenbrenfId());
                if (isset($gerantNbrEnfants)) {
                    $infoClientGerant->setNbrEnfant($gerantNbrEnfants ?? $infoClientGerant->getNbrEnfant());//obj
                }
                $gerantAge = $this->em->getRepository(Age::class)->find($newInstallPdv->getTitulaireageId());
                if (isset($gerantAge)) {
                    $infoClientGerant->setAgeClient($gerantAge ?? $infoClientGerant->getAgeClient()); //obj
                }
                $this->em->persist($infoClientGerant);
                $this->em->flush();
            }

            // Update Operateur
            $infoClientOperateur = $this->em->getRepository(InfoClient::class)->findOneBy([
                "client" => $client,
                "typeClientNew" => self::OPERATEUR_ID
            ]);
            if ($infoClientOperateur) {
                $infoClientOperateur->setNom($newInstallPdv->getTitulairenom() ?? $infoClientOperateur->getNom());
                $infoClientOperateur->setTelephone($newInstallPdv->getTitulairetel() ?? $infoClientOperateur->getTelephone());
                $this->em->persist($infoClientOperateur);
                $this->em->flush();
            }

        }



        // Get All routing Of client (to reteurn the date of install)
        $this->dateInstallPDV($client->getId(), $newInstallPdv->getMerchId(), $newInstallPdv->getCreatedAt(),
            $newInstallPdv->getId());
        // Delete New Install PDV From db after saving as " Client "
        $this->delete($newInstallPdv->getId());
    }


    /**
     * id : id Client ( client Object created ) and the merch id get from newInstallPdv Object
     * @Rest\Get("/clients/{id}/by/{idMerch}/date", name="cliendatet_show_all_with_paginator")
     */
    public function dateInstallPDV(int $id, int $idMerch, DateTime $dateCreateNewInstallPdv, int $idNewInstall)
    {
        $dateInstall = $dateCreateNewInstallPdv::ISO8601;

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
                if (!empty($date)) {
                    $day = $date[0]["day"];

                    if ($day >= $dateInstall) {
                        $data ["$key"] = $day->format('d-m-Y');
                    }
                }
            }
        }

        if (!empty($data)) {
            // remove redundancy of dates
            $result = array_unique($data);
            //order the dates
            asort($result);
            $showDateInIPad = $result[0];
        } else {
            // means that the client not added to the planning (no date )
            $showDateInIPad = "not yet affected";
        }

        $listInstallPdv = $this->em->getRepository(ListInstallPdv::class)->findOneBy(['newInstallId' => $idNewInstall]);
        $listInstallPdv->setInstallDay($showDateInIPad);
        $this->em->persist($listInstallPdv);
        $this->em->flush();
    }


}