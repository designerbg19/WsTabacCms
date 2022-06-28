<?php


namespace App\Controller\webservices;


use App\Entity\Cycle;
use App\Entity\GlobalPlanning;
use App\Entity\Merch;
use App\Entity\OnePlanning;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("api", name="api_")
 *
 */
class OnePlanningController extends MainController
{

    /**
     * @Rest\Get("/oneplannings/showall", name="onePlanning_show_all")
     * @return Response
     */
    public function index()
    {
        $onePlanning = $this->em->getRepository(OnePlanning::class)->findAll();
        if (isset($onePlanning)) {
            return $this->successResponse($onePlanning);
        }
    }

    /**
     * @Rest\Get("/oneplanning/{id}", name="onePlanning_show_by_id")
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $onePlanning = $this->em->getRepository(OnePlanning::class)->find($id);
        if (isset($onePlanning)) {
            return $this->successResponse($onePlanning);
        }
    }


    /**
     * @Rest\Get("/oneplanning/cycle/{num}", name="onePlanning_show_by_num_cycle")
     * @param int $num
     * @return Response
     */
    public function showByNumCycle(int $num)
    {
        $numCycle = $this->em->getRepository(Cycle::class)->find($num);
        if (isset($numCycle)) {
            $onePlanning = $this->em->getRepository(OnePlanning::class)->findByCycle($num);
            if (isset($onePlanning)) {
                return $this->successResponse($onePlanning);
            }
        }
    }

    /**
     * @Rest\Post("/oneplanning/create", name = "onePlanning_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $this->saveOnePlanningFunction($data);
        $this->createGlobalPlanningFunction($data);
        // if the planning created by ADMIN ( valid = true = 1)
        $user = $this->getUser();
        if($this->isGranted('ROLE_ADMIN')){
            $cycle = $this->em->getRepository(Cycle::class)->find($data["cycle_id"]);
            $cycle->setValid(1);
            if(!$cycle==-1){
                $this->em->persist($cycle);
            }else{
                $this->em->persist(null);
            }
            $this->em->flush();
        }

        return $this->successResponse(["code" => 200, "message" => "Global Planning Created."]);
    }

    /**
     * @param $data
     */
    public function createGlobalPlanningFunction($data)
    {
        $this->forward('App\Controller\webservices\GlobalPlanningController::create', [
            'data' => $data
        ]);
    }

    private function saveOnePlanningFunction($data)
    {
        $idCycle = $data["cycle_id"];
        $cycleObject = $this->em->getRepository(Cycle::class)->find($idCycle);
        foreach ($data["merchs"] as $merch) {
            $id = $merch["id"];
            $merchObject = $this->em->getRepository(Merch::class)->find($id);
            for ($i = 1; $i <= 12; $i++) {
                $days = "day$i";
                // for update
                $existOnePlanning = $this->em->getRepository(OnePlanning::class)->findOneBy([
                    'Merch' => $id,
                    'cycle' => $idCycle,
                    'classment'=>$days
                ]);
                if($existOnePlanning){
                    // update One Planning
                    $this->createOrUpdateOnePlanning($existOnePlanning,$merchObject, $cycleObject, $days, $merch[$days]);
                    // Create Global Planning (Cycle: 2 weeks )if not exist or Update if is already exist
                    $this->createGlobalPlanningFunction($data);
                }else{
                    // Create New One Planning
                    $newOnePlanning = new OnePlanning();
                    $this->createOrUpdateOnePlanning($newOnePlanning,$merchObject, $cycleObject, $days, $merch[$days]);
                    //$this->createGlobalPlanningFunction($data);

                }
            }
        }
    }

    /**
     * Function to create OnePlanning and persist data
     * @param $merchObject
     * @param $cycleObject
     * @param $day
     * @throws \Exception
     */
    private function createOrUpdateOnePlanning($onePlanningObject,$merchObject, $cycleObject, $day, $planning)
    {
        // persist data
        if (array_key_exists('date', $planning) ) {
            if(isset($planning["date"])){
                $onePlanningObject->setMerch($merchObject);
                $onePlanningObject->setDate(new \DateTime($planning["date"]));
                $onePlanningObject->setA($planning["a"] ?? null);
                $onePlanningObject->setAm($planning["am"] ?? null);
                $onePlanningObject->setCycle($cycleObject);
                $onePlanningObject->setClassment($day);
                $this->em->persist($onePlanningObject);
                $this->em->flush();
            }
        }
    }





    /******************************************************** Duplicate Planning ********************************************************/

    /**
     * Duplicate Planning Function
     * @Rest\Post("/planning/duplicate/cycle/{idThisCycle}/by/{idExistCycle}", name = "duplicate_Planning", requirements = {"idThisCycle"="\d+","idExistCycle"="\d+"})
     * @param int $idThisCycle
     * @param int $idExistCycle
     * @return Response
     */
    public function duplicateOnePlanning(int $idThisCycle, int $idExistCycle)
    {
        // Check if the two id exist in cycle
        $thisCycle = $this->em->getRepository(Cycle::class)->find($idThisCycle);
        $cycleToDuplicate = $this->em->getRepository(Cycle::class)->find($idExistCycle);
        // If Exist
        if (isset($thisCycle) && isset($cycleToDuplicate)) {
            $thisCyclePlannings = $this->em->getRepository(OnePlanning::class)->customFindByCycle($idThisCycle);
            if ($thisCyclePlannings) {
                // Remove exist plannings(OnePlanning + GlobalPlanning)
                $this->removeOnePlanningsByIdCycle($idThisCycle);
                $this->removeGlobalPlanningsByIdCycle($idThisCycle);
                // Get all Plannings of the exist cycle to duplicate
                $onePlannings = $this->em->getRepository(OnePlanning::class)->customFindByCycle($idExistCycle);
                $this->saveDuplicatedOnePlanningFunction($onePlannings, $thisCycle);
                $this->createTheDuplicatedGlobalPlanningFunction($idThisCycle);
                return $this->successResponse(["code" => 200, "message" => "Duplicate Exist Cycle Content "]);

            } else {
                $onePlannings = $this->em->getRepository(OnePlanning::class)->customFindByCycle($idExistCycle);
                $this->saveDuplicatedOnePlanningFunction($onePlannings, $thisCycle);
                $this->createTheDuplicatedGlobalPlanningFunction($idThisCycle);
            }
            return $this->successResponse(["code" => 200, "message" => "Duplicate Cycle Content "]);
        }

        if (!isset($thisCycle)) {
            return $this->successResponse(["code" => 204, "message" => "Cycle with id: $idThisCycle not exist! "]);
        }
        if (!isset($cycleToDuplicate)) {
            return $this->successResponse(["code" => 204, "message" => "Cycle with id: $idExistCycle not exist! "]);
        }


    }

    private function saveDuplicatedOnePlanningFunction($onePlannings, $thisCycle)
    {
        $beginDateCycle = $thisCycle->getDateDebut();
        foreach ($onePlannings as $onePlanning) {

            preg_match_all('!\d+!', $onePlanning["classment"], $number);
            $numberDaysToAdd = $number[0][0];
            $daysToAdd = $numberDaysToAdd - 1;
            $onePlanningDate = $beginDateCycle->modify("+$daysToAdd day");

            $merchObject = $this->em->getRepository(Merch::class)->find($onePlanning["idMerch"]);
            $this->saveDuplicatedOnePlanning($merchObject, $onePlanning, $thisCycle, $onePlanningDate);
            $beginDateCycle = new \DateTime(($thisCycle->getDateDebut())->format('Y-m-d'));
        }


    }

    private function saveDuplicatedOnePlanning($merchObject, $onePlanning, $thisCycle, $onePlanningDate)
    {
        $onePlanningObject = new OnePlanning();
        $onePlanningObject->setMerch($merchObject);
        $onePlanningObject->setDate($onePlanningDate);
        $onePlanningObject->setA($onePlanning["a"]);
        $onePlanningObject->setAm($onePlanning["am"]);
        $onePlanningObject->setCycle($thisCycle);
        $onePlanningObject->setClassment($onePlanning["classment"]);
        $this->em->persist($onePlanningObject);
        $this->em->flush();
    }

    /**
     * Exp : " day1 "  give us the date 2019-08-12T14:45:23+00:00
     * @param $onePlanning
     * @param $beginDateCycle
     * @return mixed
     */
    /* private function get_date_by_classmentDay_in_two_week($onePlanning,$beginDateCycle){
         $classmentDay = $onePlanning["classment"];
         preg_match_all('!\d+!', $classmentDay, $number);
         $numberDaysToAdd = $number[0][0];
         $daysToAdd = $numberDaysToAdd - 1;
         $onePlanningDate = $beginDateCycle->modify("+$daysToAdd day");
         return $onePlanningDate;
     }*/

    private function createTheDuplicatedGlobalPlanningFunction($numCycle)
    {
        $this->forward('App\Controller\webservices\GlobalPlanningController::createDuplicatedGlobalPlanning', [
            'numCycle' => $numCycle
        ]);

    }


    private function removeOnePlanningsByIdCycle($idThisCycle)
    {
        $onePlannings = $this->em->getRepository(OnePlanning::class)->findByCycle($idThisCycle);
        foreach ($onePlannings as $onePlanning) {
            $this->em->remove($onePlanning);
        }
        $this->em->flush();
    }

    private function removeGlobalPlanningsByIdCycle($idThisCycle)
    {
        $globalPlannings = $this->em->getRepository(GlobalPlanning::class)->findGlobalPlanningByCycle($idThisCycle);
        foreach ($globalPlannings as $globalPlanning) {
            $this->em->remove($globalPlanning);
        }
        $this->em->flush();
    }


}