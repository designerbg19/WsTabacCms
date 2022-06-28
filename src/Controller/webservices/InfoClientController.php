<?php

namespace App\Controller\webservices;

use App\Entity\Age;
use App\Entity\Client;
use App\Entity\ClientDraft;
use App\Entity\InfoClient;
use App\Entity\NbrEmployer;
use App\Entity\NbrEnfant;
use App\Entity\SituationFamilialle;
use App\Entity\TypeClient;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class InfoClientController extends MainController
{
    /**
     * @Rest\Get("/infoclient", name="infoClient_show_all")
     */
    public function index()
    {
        $infoClient = $this->em->getRepository(InfoClient::class)->findAll();

        if (isset($infoClient)) {
            return $this->successResponse($infoClient);
        }
    }

    /**
     * @Rest\Get("/infoclient/{id}", name="infoClient_show_by_id")
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $infoClient = $this->em->getRepository(InfoClient::class)->find($id);
        if (isset($infoClient)) {
            return $this->successResponse($infoClient);
        }
    }

    /**
     * @Rest\Post("/infoclient", name="infoClient_create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $infoClient = new  InfoClient();
        // set id Client and Type Client
        $typeClient = $this->em->getRepository(TypeClient::class)->find($request->request->get("type_client_id"));
        $infoClient->setTypeClientNew($typeClient);
        $client = $this->em->getRepository(Client::class)->find($request->request->get("client_id"));
        $infoClient->setClient($client);

        $SituationFamiliale = $this->em->getRepository(SituationFamilialle::class)->find($request->request->get("situationFamiliale_id"));
        $infoClient->setSituationFamil($SituationFamiliale);

        $NbrEnfant = $this->em->getRepository(NbrEnfant::class)->find($request->request->get("NbrEnfant_id"));
        $infoClient->setNbrEnfant($NbrEnfant);


        $Age = $this->em->getRepository(Age::class)->find($request->request->get("Age_id"));
        $infoClient->setAgeClient($Age);
        // Set attribut infoClient
        $infoClient->setNom($request->request->get("nom"));
        $infoClient->setTelephone($request->request->get("telephone"));
        // $infoClient->setNombreEnfants($request->request->get("nombre_enfants"));
        //persist data
        $this->em->persist($infoClient);
        $this->em->flush();
        return $this->successResponse($infoClient);
    }

    /**
     * @Rest\Post("/infoclient/{id}", name="infoClient_update")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $infoClient = $this->em->getRepository(InfoClient::class)->find($id);
        $Client = $this->em->getRepository(Client::class)->find($request->request->get("client_id"));
        $typeClient = $this->em->getRepository(TypeClient::class)->find($request->request->get("type_client_id"));
        $SituationFamiliale = $this->em->getRepository(SituationFamilialle::class)->find($request->request->get("situationFamiliale_id"));
        $Age = $this->em->getRepository(Age::class)->find($request->request->get("Age_id"));
        if (isset($infoClient)) {
            // get Type Client By ID Not Work
            $infoClient->setSituationFamil($SituationFamiliale ?? $infoClient->getSituationFamil());
            $infoClient->setAgeClient($Age ?? $infoClient->getAgeClient());

            ///??
            $infoClient->setClient($Client ?? $infoClient->getClient());
            $infoClient->setTypeClientNew($typeClient ?? $infoClient->getTypeClientNew());

            $infoClient->setNom($request->request->get("nom") ?? $infoClient->getNom());
            $infoClient->setTelephone($request->request->get("telephone") ?? $infoClient->getTelephone());
            $infoClient->setSituationFamiliale($request->request->get("situation_familiale") ?? $infoClient->getSituationFamiliale());
            $infoClient->setNombreEnfants($request->request->get("nombre_enfants") ?? $infoClient->getNombreEnfants());
            $infoClient->setAge($request->request->get("age") ?? $infoClient->getAge());
            $this->em->persist($infoClient);
            $this->em->flush();
            return $this->successResponse($infoClient);
        }
    }

    /**
     * @Rest\Delete("/infoclient/{id}",name="infoClient_delete")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, int $id)
    {
        $infoClient = $this->em->getRepository(InfoClient::class)->find($id);
        if (isset($infoClient)) {
            $this->em->remove($infoClient);
            $this->em->flush();
            return $this->successResponse($infoClient);
        }
    }

}