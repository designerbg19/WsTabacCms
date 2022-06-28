<?php

namespace App\Controller\webservices;

use App\Entity\Client;
use App\Entity\Merch;
use App\Entity\Routing;
use App\Entity\Zone;
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
class RoutingController extends MainController
{

    /**
     * @Rest\Get("/routing/showall",name = "routing_show_all")
     */
    public function index()
    {
        $routings = $this->em->getRepository(Routing::class)->customFindAllRouting();
        return $this->successResponse($routings);
    }

    /**
     * @Rest\Get("/routing/showallpagination",name = "routing_show_all_with_pagination")
     */
    public function allRoutingsWithPagination(Request $request)
    {
        $query = $this->em->getRepository(Routing::class)->customFindAllRouting();
        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),/*page number*/
            self::NUMBER_ITEM_PER_PAGE /*limit per page*/
        );
        return $this->successResponse($pagination);
    }

    /**
     * @Rest\Get("/routing/{id}", name = "routing_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        // Get just the data that we need
        $routing = $this->em->getRepository(Routing::class)->customFindRoutingById($id);
        // Get the Merch String from array to pass merch id in response
        $merch=$routing["routing"][0]["merch"];
        $str =explode('-',$merch);
        $code = (int)$str[0];
        $merchObject = $this->em->getRepository(Merch::class)->findOneBy(["code"=>$code]);
        if(isset($merchObject)){
            // add the merch id to the response
            $routing["routing"][0]["merch_id"]=$merchObject->getId();
        }

        if (isset($routing)) {
            return $this->successResponse($routing);
        }

    }

    /**
     * @Rest\Get("/routing/coderouting/{classe}/{code}/{ville}", name = "routing_show_by_code_routing", requirements = {"code"="\d+"})
     * @param string $classe
     * @param int $code
     * @param string $ville
     * @return Response
     */
    public function showByCode(string $classe, int $code, string $ville)
    {
        $routing = $this->em->getRepository(Routing::class)->findBy([
            'classe' => $classe,
            'codeRouting' => $code,
            'ville' => $ville
        ]);
        if (isset($routing)) {
            return $this->successResponse($routing);
        }
    }

    /**
     * @Rest\Post("/routing/create", name = "routing_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $routing = new Routing();
        // Get Values from Request
        $classe = $request->request->get('classe');
        $code = $request->request->get('code_routing');
        $ville = $request->request->get('ville');
        // Check if the Routing exist, defined by (classe,codeRouting,ville)
        $codeRouting = $this->em->getRepository(Routing::class)->findBy([
            'classe' => $classe,
            'codeRouting' => $code,
            'ville' => $ville
        ]);

        // If routing not exist we saved into database.
        if (!$codeRouting) {
            $routing->setClasse($classe);
            $routing->setCodeRouting($code);
            $routing->setVille($ville);
            if ($request->request->get('information')) {
                $routing->setInformation($request->request->get('information'));
            }
            if ($request->request->get('zone_id')) {
                $zone = $this->em->getRepository(Zone::class)->find($request->request->get('zone_id'));
                $routing->setZone($zone);
            }
            if ($request->request->get('merch')) {
                $routing->setMerch($request->request->get('merch'));
            }
            if ($request->request->get("clients")) {
                $routing->setNbrsPdv(count($request->request->get("clients")));
                $idClients = $request->request->get("clients");
                foreach ($idClients as $idClient) {
                    $clientObject = $this->em->getRepository(Client::class)->find($idClient);
                    $routing->addClient($clientObject);
                }
            }
            $this->em->persist($routing);
            $this->em->flush();
            $routingObject = $this->em->getRepository(Routing::class)->customFindRoutingById($routing->getId());
            return $this->successResponse(["code" => 200, "message" => "Routing Created","object"=>$routingObject]);
        } else {
            return $this->successResponse(["code" => 409, "message" => "Routing Exist"]);
        }
    }

    /**
     * @Rest\Post("/routing/{id}/update", name = "routing_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $routing = $this->em->getRepository(Routing::class)->find($id);
        if (isset($routing)) {
            if ($request->request->get('zone_id')) {
                $zone = $this->em->getRepository(Zone::class)->find($request->request->get('zone_id'));
                $routing->setZone($zone ?? $routing->getZone());
            }
            $routing->setClasse($request->request->get('classe') ?? $routing->getClasse());
            $routing->setCodeRouting($request->request->get('code_routing') ?? $routing->getCodeRouting());
            $routing->setVille($request->request->get('ville') ?? $routing->getVille());
            $routing->setInformation($request->request->get('information') ?? $routing->getInformation());
            $routing->setMerch($request->request->get('merch') ?? $routing->getMerch());
            if ($request->request->get("clients")) {
                $idClients = $request->request->get("clients");
                foreach ($idClients as $idClient) {
                    $clientObject = $this->em->getRepository(Client::class)->find($idClient);
                    $routing->addClient($clientObject);
                }
            }else{
                $this->removeExistClientsRoutingRelation($routing);
            }
            $this->em->persist($routing);
            $this->em->flush();
            $routingObject = $this->em->getRepository(Routing::class)->customFindRoutingById($routing->getId());
            return $this->successResponse(["code" => 200, "message" => "Routing Updated","object"=>$routingObject]);
        }
    }

    /**
     * @Rest\Delete("/routing/{id}/delete", name = "routing_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $routing = $this->em->getRepository(Routing::class)->find($id);
        if (isset($routing)) {
            $this->em->remove($routing);
            $this->em->flush();
            return $this->successResponse(["code" => 200, "message" => "Routing Deleted"]);
        }
    }

    /**
     * Delete the relation of routing _client
     * @param Routing|null $routing
     */
    private function removeExistClientsRoutingRelation(?Routing $routing)
    {
        $clientsRelation = $routing->getClients();
        foreach ($clientsRelation as $relation) {
            $routing->removeClient($relation);
            $this->em->flush();
        }
    }


}