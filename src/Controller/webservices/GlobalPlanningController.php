<?php

namespace App\Controller\webservices;

use App\Entity\ClientState;
use App\Entity\ClientStateByCycleByDay;
use App\Entity\Notification;
use DatePeriod;
use DateInterval;
use App\Entity\Cycle;
use App\Entity\OnePlanning;
use App\Entity\GlobalPlanning;
use App\Entity\Routing;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route ("api", name="api_")
 *
 */
class GlobalPlanningController extends MainController
{

    /**
     * @Rest\Get("/globalplannings/showall", name="globalPlannings_show_all")
     * @return Response
     */
    public function index()
    {
        $globalPlannings = $this->em->getRepository(GlobalPlanning::class)->findAll();
        if (isset($globalPlannings)) {
            return $this->successResponse($globalPlannings);
        }
    }

    /**
     * @Rest\Get("/globalplannings/{id}", name="globalPlannings_show_by_id")
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $globalPlannings = $this->em->getRepository(GlobalPlanning::class)->find($id);
        if (isset($globalPlannings)) {
            return $this->successResponse($globalPlannings);
        }
    }


    /*************************************************************** Custom Show ***************************************************************/

    /**
     * Get planning of all Merchs by Cycle (for BackEnd Part)
     * @Rest\Get("/globalplannings/cycle/{idCycle}/all", name="globalPlannings_show_all_detail_by_numcycle")
     * @param int $idCycle
     * @return Response
     */
    public function showPlanningOfMerchsByCycle(int $idCycle)
    {
        $cycleObject = $this->em->getRepository(Cycle::class)->find($idCycle);

        if (isset($cycleObject)) {
            $globalPlannings = $this->em->getRepository(GlobalPlanning::class)->findAllByCycle($idCycle);
            foreach ($globalPlannings as $golbalPlanning) {
                $routingDataInDays = $this->searchTheRoutingOfDaysInGlobalPlannings($golbalPlanning);
                $data [] = array(
                    'merchId' => $golbalPlanning['merchId'],
                    'plannings' => array(
                        'day1' => $routingDataInDays[0],
                        'day2' => $routingDataInDays[1],
                        'day3' => $routingDataInDays[2],
                        'day4' => $routingDataInDays[3],
                        'day5' => $routingDataInDays[4],
                        'day6' => $routingDataInDays[5],
                        'day7' => $routingDataInDays[6],
                        'day8' => $routingDataInDays[7],
                        'day9' => $routingDataInDays[8],
                        'day10' => $routingDataInDays[9],
                        'day11' => $routingDataInDays[10],
                        'day12' => $routingDataInDays[11],
                        'day13' => $routingDataInDays[12]
                    )
                );

            }
            if (!empty($data)) {
                return $this->successResponse([
                    'idCycle' => $idCycle,
                    'merchs' => $data
                ]);
            }else{
                return $this->successResponse([
                    'code' => 204,
                    'message' => "No Content"
                ]);
            }
        }else{
            return $this->successResponse([
                'code' => 204,
                'message' => "No Content"
            ]);
        }

    }


    /**
     * Get all clients by Merch by Cycle (for App iPad Part)
     * @Rest\Get("/globalplannings/clientsbymerchid/{merchid}/cycle", name="globalPlannings_show_client_by_merch_by_cycle")
     * @param int $merchid
     * @return Response
     * @throws \Exception
     */
    public function showClientsByMerchIncycle(int $merchid)
    {
        $numberOfCycle = $this->getCurrentCycleNumberByDateNow();
        $cycleId = $numberOfCycle[0];
        $numCycle = $numberOfCycle[1];
        $cycle = $this->em->getRepository(Cycle::class)->find($cycleId);
        if ($cycle->getValid() == 1) {
            $globalPlanningObject = $this->em->getRepository(GlobalPlanning::class)->findOneBy([
                'merchId' => $merchid,
                'numCycle' => $cycleId
            ]);

            if (isset($globalPlanningObject)) {
                $clientsDataInDays = $this->searchTheRoutingOfDaysInGlobalPlanningByCycle($globalPlanningObject);
                $data [] = array(
                    "numCycle" => $numCycle,
                    "idMerch" => $globalPlanningObject->getMerchId(),
                    "clients" => $clientsDataInDays
                );

                return $this->successResponse($data);
            } else {
                return $this->successResponse(["code" => 204, "message" => "No Planning Yet /Cycle"]);
            }
        } else {
            $data [] = array(
                "numCycle" => $numCycle,
                "idMerch" => $merchid,
                "clients" => []
            );
            return $this->successResponse($data);
        }

    }


    /**
     * Function to get all clients by Merch by day (for App iPad Part)
     * @Rest\Get("/globalplannings/clientsbymerchid/{merchid}/day", name="globalPlannings_show_client_by_merch_by_day")
     * @param int $merchid
     * @return Response
     * @throws \Exception
     */
    public function showClientsByMerchByDay(int $merchid)
    {
        $numberOfCycle = $this->getCurrentCycleNumberByDateNow();
        $cycleId = $numberOfCycle[0];
        $numCycle = $numberOfCycle[1];
        $cycle = $this->em->getRepository(Cycle::class)->find($cycleId);
        if ($cycle->getValid() == 1) {
            $globalPlanningObject = $this->em->getRepository(GlobalPlanning::class)->findOneBy([
                'merchId' => $merchid,
                'numCycle' => $cycleId,
            ]);

            if (isset($globalPlanningObject)) {
                $clientsDataInDays = $this->searchTheRoutingOfDaysInGlobalPlanningByDay($globalPlanningObject);
                $data [] = array(
                    "numCycle" => $numCycle,
                    "idMerch" => $globalPlanningObject->getMerchId(),
                    "clients" => $clientsDataInDays
                );
                return $this->successResponse($data);
            } else {
                return $this->successResponse(["code" => 204, "message" => "No Planning Yet /Day"]);
            }
        } else {
            $data [] = array(
                "numCycle" => $numCycle,
                "idMerch" => $merchid,
                "clients" => []
            );
            return $this->successResponse($data);
        }

    }





    /************************************************************* Create GlobalPlanning *************************************************************/

    /**
     * @Rest\Get("/globalplannings", name="globalPlannings_create")
     *
     */
    public function create($data)
    {
        $numCycle = $data["cycle_id"];
        $idOfMerchsInOnePlanning = $this->em->getRepository(OnePlanning::class)->findJustTheMerchsId($numCycle);
        foreach ($idOfMerchsInOnePlanning as $idMerchs) {
            $merchId = $idMerchs['id'];
            $arrayOfIdOnePlanning = $this->em->getRepository(OnePlanning::class)->findTheIdAndClassmentOfOnePlanningByMerchByCycle($merchId,
                $numCycle);
            $globalPlanningObject = new GlobalPlanning();
            foreach ($arrayOfIdOnePlanning as $item) {
                $this->saveGlobalPlanningFunction($globalPlanningObject, $item, $merchId, $numCycle);
            }
        }
        //return $this->successResponse(["code"=>200,"message"=>"Global Planning Created."]);

    }


    public $arrayOfAllDays = array(
        "day1",
        "day2",
        "day3",
        "day4",
        "day5",
        "day6",
        "day7",
        "day8",
        "day9",
        "day10",
        "day11",
        "day12",
        "day13"
    );

    public function saveGlobalPlanningFunction($globalPlanningObject, $item, $merchId, $numCycle)
    {
        $idOnePlanning = $item['id'];

        foreach ($this->arrayOfAllDays as $day) {
            $methodSetter = 'set' . ucfirst($day);
            if ($item['classment'] == $day) {
                $globalPlanningObject->$methodSetter($idOnePlanning);
            }
        }

        $globalPlanningObject->setMerchId($merchId);
        $globalPlanningObject->setNumCycle($numCycle);
        $this->em->persist($globalPlanningObject);
        $this->em->flush();
    }


    public function createOrUpdateFunction($merchId, $numCycle)
    {
        $idOfMerchsInGlobalPlanning = $this->em->getRepository(GlobalPlanning::class)->findJustTheMerchsId($numCycle);
        foreach ($idOfMerchsInGlobalPlanning as $item) {
            $arrayTmp[] = $item['merchId'];
        }

        if (in_array($merchId, $arrayTmp)) {
            $existGlobalPlanningObject = $this->em->getRepository(GlobalPlanning::class)->findOneBy([
                'merchId' => $merchId,
                'numCycle' => $numCycle,
            ]);
            $arrayOfIdOnePlanning = $this->em->getRepository(OnePlanning::class)->findTheIdAndClassmentOfOnePlanningByMerchByCycle($merchId,
                $numCycle);
            foreach ($arrayOfIdOnePlanning as $item) {
                $this->saveGlobalPlanningFunction($existGlobalPlanningObject, $item, $merchId, $numCycle);
            }
        } else {
            $arrayOfIdOnePlanning = $this->em->getRepository(OnePlanning::class)->findTheIdAndClassmentOfOnePlanningByMerchByCycle($merchId,
                $numCycle);
            $createNewGlobalPlanningObject = new GlobalPlanning();
            foreach ($arrayOfIdOnePlanning as $item) {
                $this->saveGlobalPlanningFunction($createNewGlobalPlanningObject, $item, $merchId, $numCycle);
            }
        }

    }

    /**
     * Function to search the routing of days of all the Merchs in GlobalPlanning
     * @param $golbalPlanning
     * @return array
     */
    private function searchTheRoutingOfDaysInGlobalPlannings($golbalPlanning)
    {
        foreach ($this->arrayOfAllDays as $day) {
            if (isset($golbalPlanning[$day])) {
                $onePlanningDay = $this->em->getRepository(OnePlanning::class)->find($golbalPlanning[$day]);
                $a = $onePlanningDay->getA();
                $am = $onePlanningDay->getAM();
                $day = $onePlanningDay->getDate();
                $dataOfDay = array('a' => $a, 'am' => $am, 'date' => $day);
            } else {
                $dataOfDay = null;
            }
            $dataOfDays [] = $dataOfDay;
        }
        return $dataOfDays;
    }

    /**
     * Function to search all routing days of one Merch in GlobalPlanning by Cycle
     * @param $golbalPlanning
     * @return array
     */
    private function searchTheRoutingOfDaysInGlobalPlanningByCycle($globalPlanningObject)
    {
        foreach ($this->arrayOfAllDays as $day) {
            $getDayI = 'get' . ucfirst($day);
            $idOnePlanning = $globalPlanningObject->$getDayI();
            if ($idOnePlanning) {
                $onePlanningDay = $this->em->getRepository(OnePlanning::class)->find($idOnePlanning);
                $a = $onePlanningDay->getA();
                $am = $onePlanningDay->getAM();
                $day = $onePlanningDay->getDate();
                $classment = $onePlanningDay->getClassment();
                $allClientInRoutingObjectA_Am = $this->em->getRepository(Routing::class)->findAllClientInRoutingAAm($a,
                    $am);
                foreach ($allClientInRoutingObjectA_Am as &$item) {
                    $item['one_planning_id'] = $idOnePlanning;
                    $item['coordinates'] = ["latitude" => $item["latitude"], "longitude" => $item["longitude"]];
                    $stateOfClient = $this->stateOfClientByCycleByDay($item, $idOnePlanning);
                    if ($stateOfClient) {
                        $item['stateId'] = $stateOfClient;
                    } else {
                        $item['stateId'] = 1;
                    }
                }
                $dataOfDay = $allClientInRoutingObjectA_Am;
            } else {
                $dataOfDay = null;
            }
            $dataOfDays [] = $dataOfDay;
        }
        $arrayOfClients = array_merge((array)$dataOfDays[0], (array)$dataOfDays[1], (array)$dataOfDays[2],
            (array)$dataOfDays[3], (array)$dataOfDays[4],
            (array)$dataOfDays[5], (array)$dataOfDays[6], (array)$dataOfDays[7], (array)$dataOfDays[8],
            (array)$dataOfDays[9], (array)$dataOfDays[10],
            (array)$dataOfDays[11], (array)$dataOfDays[12]);
        return $arrayOfClients;
    }


    /**
     * Function to search all routing days of one Merch in GlobalPlanning by Day
     * @param $golbalPlanning
     * @return array
     * @throws \Exception
     */
    private function searchTheRoutingOfDaysInGlobalPlanningByDay($globalPlanningObject)
    {
        foreach ($this->arrayOfAllDays as $day) {
            $methodGetTheDayInGlobalPlanning = 'get' . ucfirst($day);
            $idOnePlanning = $globalPlanningObject->$methodGetTheDayInGlobalPlanning();
            if ($idOnePlanning) {
                $onePlanningDay = $this->em->getRepository(OnePlanning::class)->find($idOnePlanning);
                $a = $onePlanningDay->getA();
                $am = $onePlanningDay->getAM();
                $day = $onePlanningDay->getDate();
                $classment = $onePlanningDay->getClassment();
                // get today oder in cycle to show data by current day (fr Date)
                $orderCurrentDayInCycle = $this->orderOfTodayInCurrentCycle();
                $allClientInRoutingObjectA_Am = $this->em->getRepository(Routing::class)->findAllClientInRoutingAAm($a,
                    $am);
                /**
                 * to fix date and date of today ********
                 */
                // print_r($orderCurrentDayInCycle); die();
                if ($orderCurrentDayInCycle === $classment) {
                    foreach ($allClientInRoutingObjectA_Am as &$item) {
                        $stateOfClient = $this->stateOfClientByCycleByDay($item, $idOnePlanning);
                        $item['one_planning_id'] = $idOnePlanning;
                        $item['coordinates'] = ["latitude" => $item["latitude"], "longitude" => $item["longitude"]];
                        if ($stateOfClient) {
                            $item['stateId'] = $stateOfClient;
                        } else {
                            $item['stateId'] = 1;
                        }

                    }
                    $dataOfDay = $allClientInRoutingObjectA_Am;
                } else {
                    $dataOfDay = null;
                }


            } else {
                $dataOfDay = null;
            }
            $dataOfDays [] = $dataOfDay;
        }

        return array_merge((array)$dataOfDays[0], (array)$dataOfDays[1], (array)$dataOfDays[2], (array)$dataOfDays[3],
            (array)$dataOfDays[4],
            (array)$dataOfDays[5], (array)$dataOfDays[6], (array)$dataOfDays[7], (array)$dataOfDays[8],
            (array)$dataOfDays[9], (array)$dataOfDays[10],
            (array)$dataOfDays[11], (array)$dataOfDays[12]);

    }

    private function stateOfClientByCycleByDay($item, $idOnePlanning)
    {
        // The Client Object ($item)
        // The Id of OnePlanning [date/a/am/cycle/merch] ($idOnePlanning)
        $clientStateByCycleByDayObject = $this->em->getRepository(ClientStateByCycleByDay::class)->findOneBy([
            'clientId' => $item['clientId'],
            'OnePlanningId' => $idOnePlanning
        ]);

        if ($clientStateByCycleByDayObject) {
            $idStateOfClient = $clientStateByCycleByDayObject->getEtatId();
            $clientStateObject = $this->em->getRepository(ClientState::class)->find($idStateOfClient);
            $clientStateLabel = $clientStateObject->getLabel();
            $clientStateId = $clientStateObject->getId();
            return $clientStateId;
        }
        return null;
    }


    /**
     * Function to get the order of day in cycle (day 1 / day 3 ...)
     *
     * @return string
     * @throws \Exception
     */
    private function orderOfTodayInCurrentCycle()
    {
        $numberOfCycle = $this->getCurrentCycleNumberByDateNow();
        $cycleId = $numberOfCycle[0];
        $cycleObject = $this->em->getRepository(Cycle::class)->find($cycleId);
        $dateDebutCycle = $cycleObject->getDateDebut();
        //Manual date just for test
        $nowDate = new \DateTime("2019-08-26T14:45:23+00:00");
        //$nowDate =  new \DateTime("now");
        $difference = $nowDate->diff($dateDebutCycle);
        $number = ($difference->d) + 1;
        $orderDay = "day" . $number;
        return $orderDay;
    }

    /******************************************************** Duplicate Planning ********************************************************/

    /**
     * @Rest\Get("/globalplannings/duplicate", name="globalPlannings_create_a_duplication")
     */
    public function createDuplicatedGlobalPlanning($numCycle)
    {
        $idOfMerchsInOnePlanning = $this->em->getRepository(OnePlanning::class)->findJustTheMerchsId($numCycle);
        foreach ($idOfMerchsInOnePlanning as $idMerchs) {
            $merchId = $idMerchs['id'];
            $arrayOfIdOnePlanning = $this->em->getRepository(OnePlanning::class)->findTheIdAndClassmentOfOnePlanningByMerchByCycle($merchId,
                $numCycle);
            $globalPlanningObject = new GlobalPlanning();
            foreach ($arrayOfIdOnePlanning as $item) {
                $this->saveGlobalPlanningFunction($globalPlanningObject, $item, $merchId, $numCycle);
            }
        }
    }












    /********************* Clients (A visité ) *****************************/


    /**
     * Function to get all clients by Merch by day (for App iPad Part) a Visité
     * @Rest\Get("/globalplannings/clientstovisitingbymerchid/{merchid}/day", name="globalPlannings_show_client_tovisiting_by_merch_by_day")
     * @param int $merchid
     * @return Response
     * @throws \Exception
     */
    public function showToVisitingClientsByMerchByDay(int $merchid)
    {
        $numberOfCycle = $this->getCurrentCycleNumberByDateNow();
        $cycleId = $numberOfCycle[0];
        $numCycle = $numberOfCycle[1];
        $cycle = $this->em->getRepository(Cycle::class)->find($cycleId);
        if ($cycle->getValid() == 1) {
            $globalPlanningObject = $this->em->getRepository(GlobalPlanning::class)->findOneBy([
                'merchId' => $merchid,
                'numCycle' => $cycleId,
            ]);

            if (isset($globalPlanningObject)) {
                $clientsDataInDays = $this->searchTheRoutingOfDaysInGlobalPlanningByDay($globalPlanningObject);
                $clientToVisitingInDay = $this->getJustTheClientToVisiting($clientsDataInDays);
                $data [] = array(
                    "numCycle" => $numCycle,
                    "idMerch" => $globalPlanningObject->getMerchId(),
                    "clients" => $clientToVisitingInDay
                );
                return $this->successResponse($data);
            } else {
                return $this->successResponse(["code" => 204, "message" => "No Content"]);
            }
        } else {
            $data [] = array(
                "numCycle" => $numCycle,
                "idMerch" => $merchid,
                "clients" => []
            );
            return $this->successResponse($data);
        }

    }


    /**
     * Get all clients by Merch by Cycle (for App iPad Part)
     * @Rest\Get("/globalplannings/clientstovisitingbymerchid/{merchid}/cycle", name="globalPlannings_show_client_tovisiting_by_merch_by_cycle")
     * @param int $merchid
     * @return Response
     * @throws \Exception
     */
    public function showToVisitingClientsByMerchIncycle(int $merchid)
    {
        $numberOfCycle = $this->getCurrentCycleNumberByDateNow();
        $cycleId = $numberOfCycle[0];
        $numCycle = $numberOfCycle[1];
        $cycle = $this->em->getRepository(Cycle::class)->find($cycleId);
        if ($cycle->getValid() == 1) {
            $globalPlanningObject = $this->em->getRepository(GlobalPlanning::class)->findOneBy([
                'merchId' => $merchid,
                'numCycle' => $cycleId
            ]);

            if (isset($globalPlanningObject)) {
                $clientsDataInCycle = $this->searchTheRoutingOfDaysInGlobalPlanningByCycle($globalPlanningObject);
                $clientToVisitingInCycle = $this->getJustTheClientToVisiting($clientsDataInCycle);
                $data [] = array(
                    "numCycle" => $numCycle,
                    "idMerch" => $globalPlanningObject->getMerchId(),
                    "clients" => $clientToVisitingInCycle
                );

                return $this->successResponse($data);
            } else {
                return $this->successResponse(["code" => 204, "message" => "No Content"]);
            }
        } else {
            $data [] = array(
                "numCycle" => $numCycle,
                "idMerch" => $merchid,
                "clients" => []
            );
            return $this->successResponse($data);
        }

    }

    private function getJustTheClientToVisiting(array $clients)
    {
        foreach ($clients as $data) {
            if ($data['stateId'] == 1) {
                $arrayToVisitingClients[] = $data;
            }
        }
        if (!empty($arrayToVisitingClients)) {
            return $arrayToVisitingClients;
        } else {
            return [];
        }
    }










    /********************* Clients (A Reporté ) *****************************/


    /**
     * Function to get all clients by Merch by day (for App iPad Part)
     * @Rest\Get("/globalplannings/clientstoreportingbymerchid/{merchid}/day", name="globalPlannings_show_client_toreporting_by_merch_by_day")
     * @param int $merchid
     * @return Response
     * @throws \Exception
     */
    public function showToReportingClientsByMerchInDay(int $merchid)
    {
        $numberOfCycle = $this->getCurrentCycleNumberByDateNow();
        $cycleId = $numberOfCycle[0];
        $numCycle = $numberOfCycle[1];
        $cycle = $this->em->getRepository(Cycle::class)->find($cycleId);
        if ($cycle->getValid() == 1) {
            $globalPlanningObject = $this->em->getRepository(GlobalPlanning::class)->findOneBy([
                'merchId' => $merchid,
                'numCycle' => $cycleId,
            ]);

            if (isset($globalPlanningObject)) {
                $clientsDataInDays = $this->searchTheRoutingOfDaysInGlobalPlanningByDay($globalPlanningObject);
                $clientToReportingInDay = $this->getJustTheClientToReporting($clientsDataInDays);
                // var_dump($clientsDataInDays);die();

                $data [] = array(
                    "numCycle" => $numCycle,
                    "idMerch" => $globalPlanningObject->getMerchId(),
                    "clients" => $clientToReportingInDay
                );

                return $this->successResponse($data);
            }
        } else {
            $data [] = array(
                "numCycle" => $numCycle,
                "idMerch" => $merchid,
                "clients" => []
            );
            return $this->successResponse($data);
        }


    }


    /**
     * Get all clients by Merch by Cycle (for App iPad Part)
     * @Rest\Get("/globalplannings/clientstoreportingbymerchid/{merchid}/cycle", name="globalPlannings_show_client_toreporting_by_merch_by_cycle")
     * @param int $merchid
     * @return Response
     * @throws \Exception
     */
    public function showToReportingClientsByMerchIncycle(int $merchid)
    {
        $numberOfCycle = $this->getCurrentCycleNumberByDateNow();
        $cycleId = $numberOfCycle[0];
        $numCycle = $numberOfCycle[1];
        $cycle = $this->em->getRepository(Cycle::class)->find($cycleId);
        if ($cycle->getValid() == 1) {
            $globalPlanningObject = $this->em->getRepository(GlobalPlanning::class)->findOneBy([
                'merchId' => $merchid,
                'numCycle' => $cycleId
            ]);

            if (isset($globalPlanningObject)) {
                $clientsDataInDays = $this->searchTheRoutingOfDaysInGlobalPlanningByCycle($globalPlanningObject);
                $clientToReportingInCycle = $this->getJustTheClientToReporting($clientsDataInDays);
                $data [] = array(
                    "numCycle" => $numCycle,
                    "idMerch" => $globalPlanningObject->getMerchId(),
                    "clients" => $clientToReportingInCycle
                );

                return $this->successResponse($data);
            }
        } else {
            $data [] = array(
                "numCycle" => $numCycle,
                "idMerch" => $merchid,
                "clients" => []
            );
            return $this->successResponse($data);
        }

    }

    /**
     * @param array $clients
     * @return TYPE_NAME|array
     */
    private function getJustTheClientToReporting(array $clients)
    {
        foreach ($clients as $data) {
            if ($data['stateId'] == 3) {
                $arrayReportingClients[] = $data;
            }
        }
        if (!empty($arrayReportingClients)) {
            return $arrayReportingClients;
        } else {
            return [];
        }

    }

}





