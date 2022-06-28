<?php

namespace App\Controller\webservices;


use App\Entity\Merch;
use App\Entity\Notification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route ;

/**
 * @Route ("api", name="api_")
 *
 */
class NotificationController extends MainController
{
    /**
     * Custom Display for (BO)
     * @Rest\Get("/notificationscustompagination/showall", name="notifications_show_all")
     */
    public function index(Request $request)
    {
        $notifications = $this->em->getRepository(Notification::class)->CustomFindall();
        foreach ($notifications as $notification) {
            $notificationsMerchs = $this->em->getRepository(Notification::class)->findByMerchs($notification["id"]);
            foreach ($notificationsMerchs as $merchs) {
                $ids [] = ["id"=>$merchs["id"],"fullName"=>$merchs["full_name"]];
            }
            // If no merch associete to notification return null array
            if(empty($ids) ){ $ids = [];}
            $data[]=array(
                "notification"=>$notification,
                "merchs_id"=>$ids
            );
            $ids = null;
        }

        $pagination = $this->paginator->paginate(
            $data, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            self::NUMBER_ITEM_PER_PAGE /*limit per page*/
        );
        if(isset($pagination))
            {
            return $this->successResponse($pagination);
            }

    }

    /**
     * @Rest\Get("/notificationspagination/showall", name="notifications_pagination_show_all")
     */
    public function showAllWithPagination(Request $request)
    {
        $query = $this->em->getRepository(Notification::class)->CustomFindAllWithPagination();
        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            self::NUMBER_ITEM_PER_PAGE /*limit per page*/
        );
        if(isset($pagination)) {
            return $this->successResponse($pagination);
        }
    }

    /**
     * @Rest\Get("/notifications/{id}", name="notifications_show_by_id")
     * @return Response\
     */
    public function show(int $id)
    {
        $notifications = $this->em->getRepository(Notification::class)->find($id);
        if(isset($notifications)) {
            return $this->successResponse($notifications);
        }
    }

    /**
     * @Rest\Post("/notifications/create", name="notifications_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $jsonData = json_decode($request->getContent(),true);
            $notifications = new  Notification();
            $notifications->setTitle($jsonData["title"]);
            $notifications->setText($jsonData["text"]);
            $notifications->setCycleId($jsonData["id_cycle"]);
            $arrayOfMerchsId = $jsonData["merchs"];
                if(isset($arrayOfMerchsId)){
                    foreach ($arrayOfMerchsId as $merchId){
                        $merchObject = $this->em->getRepository(Merch::class)->find($merchId);
                        $notifications->addMerch($merchObject);
                    }
                }
                $notifications->setVisibility(0);
            $this->em->persist($notifications);

        $this->em->flush();
        return $this->successResponse(["code"=>200,"message"=>"Notification Created"]);
    }

    /**
     * @Rest\Post("/notifications/update", name="notifications_update")
     * @return Response
     */
    public function update(Request $request)
    {
        $jsonData = json_decode($request->getContent(),true);
            $notifications = $this->em->getRepository(Notification::class)->find($jsonData["id"]);
            $notifications->setTitle($jsonData["title"] ?? $notifications->getTitle());
            $notifications->setText($jsonData["text"] ?? $notifications->getText());
            $notifications->setCycleId($jsonData["id_cycle"] ?? $notifications->getCycleId());
            $arrayOfMerchsId = $jsonData["merchs"];
            if(!empty($arrayOfMerchsId)){
                foreach ($arrayOfMerchsId as $merchId){
                    $merchObject = $this->em->getRepository(Merch::class)->find($merchId);
                    $notifications->addMerch($merchObject);
                }
            }else{
                $allMerchs = $notifications->getMerch();
                foreach ($allMerchs as $merch){
                    $notifications->removeMerch($merch);
                }
            }

            $this->em->persist($notifications);
        $this->em->flush();
        return $this->successResponse(["code"=>200,"message"=>"Notification updated"]);
    }

    /**
     * @Rest\Delete("/notifications/{id}/delete",name="notifications_delete")
     */
    public  function delete(int $id)
    {
        $notifications = $this->em->getRepository(Notification::class)->find($id);
        if(isset($notifications)) {
            $this->em->remove($notifications);
            $this->em->flush();
            return $this->successResponse(["code"=>200,"message"=>"Deleted with success"]);
        }
    }


/************************************ Notification by cycle / merch  (iPad) *******************************************/
    /**
     * Function to get all Notifications by Cycle (for App iPad Part)
     * @Rest\Get("/notificationsbycycle", name="notifications_by_cycle")
     * @return Response
     * @throws \Exception
     */
    public function showNotificationsByCycle()
    {
        $numberOfCycle = $this->getCurrentCycleNumberByDateNow();
        $cycleId =$numberOfCycle[0];
        $numCycle =$numberOfCycle[1];
        $notificationByCycle = $this->em->getRepository(Notification::class)->findNotificationsByCycle($cycleId);
        if(isset($notificationByCycle)){
            $data [] = array("num_cycle"=>$numCycle,
                "notifications"=> $notificationByCycle
            );
            return $this->successResponse($notificationByCycle);
        }
    }


    /**
     * Function to get all Notifications by Merch (for App iPad Part)
     * @Rest\Get("/notificationsbycyclebymerch/{id}", name="notifications_by_cycle_by_merch")
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function showNotificationsByMerch(int $id)
    {
        $merchObject = $this->em->getRepository(Merch::class)->find($id);
        // if Merch id exist than continue
        if(isset($merchObject)) {
            $numberOfCycle = $this->getCurrentCycleNumberByDateNow();
            $cycleId = $numberOfCycle[0];
            $numCycle = $numberOfCycle[1];
            $notificationByCycleByMerch = $this->em->getRepository(Notification::class)->findNotificationsByCycleByMerch($cycleId,
                $id);
            $notificationByCycle = $this->em->getRepository(Notification::class)->findNotificationsByCycle($cycleId);
            if ($notificationByCycleByMerch) {
                $data [] = array(
                    //"num_cycle" => $numCycle,
                    "notification_by_merch" => $notificationByCycleByMerch,
                    "notification_by_cycle" => $notificationByCycle
                );

                return $this->successResponse($data);
            } else {
                $data [] = array(
                    //"num_cycle" => $numCycle,
                    "notification_by_merch" => $notificationByCycleByMerch,
                    "notification_by_cycle" => $notificationByCycle
                );
                return $this->successResponse($data);
            }
        }

    }

/****************** published / unpublished *******************/
    /**
     * Function to change visibility of the notification (0:not published/1:published)
     * @Rest\Post("/notificationvisibility/{id}", name="notifications_visibility_by_cycle_by_merch")
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function notificationVisibility(int $id)
    {
        $notifications = $this->em->getRepository(Notification::class)->find($id);
        $visibility = $notifications->getVisibility();
        if($visibility == 0){
            $notifications->setVisibility(1);
        }else{
            $notifications->setVisibility(0);
        }
        $this->em->persist($notifications);
        $this->em->flush();
        return $this->successResponse(["code"=>200,"message"=>"Visibility Changed"]);
    }


}