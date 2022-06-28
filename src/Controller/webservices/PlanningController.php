<?php

namespace App\Controller\webservices;

use App\Entity\DateRouting;
use App\Controller\webservices\DateRoutingController;
use App\Entity\Merch;
use App\Entity\Planning;
use DatePeriod;
use DateInterval;
use App\Entity\Routing;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api", name="api_")
 *
 */
class PlanningController extends MainController
{


    /**
     * @Rest\Get("/planning/cycle/{numCycle}",name = "planning_show_custom")
     * @param int $numCycle
     * @return Response
     */
    public function findPlanningByNumCycle(int $numCycle)
    {
        $planning = $this->em->getRepository(Planning::class)->findByNumCycle($numCycle);
            return $this->successResponse($planning);

    }


    /**
     * @Rest\Get("/planning/findbymerchanddate",name = "planning_show_custom_2")
     * @return Response
     */
    public function findPlanningByMerchAndDate()
    {
        $objectplanning = $this->em->getRepository(Planning::class)->findOneBy([
            'merchName' => "begi begi",
            'datePlanning' => new \DateTime("2019-07-20T00:00:00+00:00"),
        ]);
        return $this->successResponse($objectplanning);

    }

    /**
     * @Rest\Get("/planning/showall",name = "planning_show_all")
     */
      public function index()
        {
            $planning = $this->em->getRepository(Planning::class)->findAll();
            if (isset($planning)) {
                return $this->successResponse($planning);
            }
        }


    /**
     * @Rest\Get("/planning/{id}", name = "planning_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
       public function show(int $id)
        {
            $planning = $this->em->getRepository(Planning::class)->find($id);
            if (isset($planning)) {
                return $this->successResponse($planning);
            }

        }

    /**
     * @Rest\Post("/planning/create", name = "planning_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $idObjetDateRouting = (int)$this->saveDateRouting($data)->getContent();
        $this->savePlanning($data, $idObjetDateRouting);
        return $this->successResponse("Planning Created.");
    }

    public function savePlanning($data, $idObjetDateRouting)
    {
        $dateDebutPlanning = new \DateTime($data["date_debut"]);
        $dateFinPlanning = new \DateTime($data["date_fin"]);
        $objectDateRouting = $this->em->getRepository(DateRouting::class)->find($idObjetDateRouting);
        $arrayOfMerchs = $data["merchs"];

        foreach ($arrayOfMerchs as $merch) {
            $merchId = $merch["merch_id"];
            $merchName = $merch["merch_name"];
            $objectmerch = $this->em->getRepository(Merch::class)->find($merchId);
            $arrayofPlannings = $merch["jour"];

            foreach ($arrayofPlannings as $planning) {
                //Planning
                    $objectplanning = new Planning();
                    $objectplanning->setMerch($objectmerch);
                    $objectplanning->setMerchName($merchName);
                    $objectplanning->setNumCycle($data["num_cycle"]);
                    if(isset($planning["_m"])){
                        $objectplanning->setM($planning["_m"]);
                    }
                    $objectplanning->setMData("data");
                    if(isset($planning["_m"])){
                       $objectplanning->setM($planning["_m"]);
                    }
                    $objectplanning->setAmData("data2");
                    $objectplanning->setDatePlanning(new \DateTime($planning["date"]));
                    $objectplanning->setDateRouting($objectDateRouting);
                    $this->em->persist($objectplanning);
                    $this->em->flush();
            }
        }
    }

    // Function to save Date into DateRouting Entity
    public function saveDateRouting($data)
    {
        $result = $this->forward('App\Controller\webservices\DateRoutingController::create', [
            'data' => $data,
        ]);
        return $result;
    }

    /**
     * @Rest\Post("/planning/cycle/{id}/update", name = "planning_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public
    function update(int $id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $this->updatePlanning($data);
        return $this->successResponse("Planning updated.");


    }

    public function updatePlanning($data)
    {
        $arrayOfMerchs = $data["merchs"];
        foreach ($arrayOfMerchs as $merch) {
            $merchId = $merch["merch_id"];
            $merchName = $merch["merch_name"];
            $objectmerch = $this->em->getRepository(Merch::class)->find($merchId);
            $arrayofPlannings = $merch["jour"];

            foreach ($arrayofPlannings as $planning) {

                $objectplanning = $this->em->getRepository(Planning::class)->findOneBy([
                    'merch' => 14,
                    'datePlanning' => new \DateTime($planning["date"]),
                ]);
                //Planning
                $objectplanning->setMerch($objectmerch);
                $objectplanning->setMerchName($merchName);
                $objectplanning->setNumCycle($data["num_cycle"]);
                if(isset($planning["_m"])){
                    $objectplanning->setM($planning["_m"] ?? $objectplanning->getM());
                }
                $objectplanning->setMData("data" ?? $objectplanning->getMData());
                if(isset($planning["_am"])){
                    $objectplanning->setAM($planning["_am"] ?? $objectplanning->getAM());
                }
                $objectplanning->setAmData("data2" ?? $objectplanning->getAmData());
                $objectplanning->setDatePlanning($objectplanning->getDatePlanning());
                $objectplanning->setDateRouting($objectplanning->getDateRouting());
                $this->em->persist($objectplanning);
                $this->em->flush();
            }
        }
    }

    /**
     * @Rest\Delete("/planning/{id}/delete", name = "planning_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public
    function delete(int $id)
    {
        $planning = $this->em->getRepository(planning::class)->find($id);
        if (isset($planning)) {
            $this->em->remove($planning);
            $this->em->flush();
            return $this->successResponse($planning);
        }
    }

}






