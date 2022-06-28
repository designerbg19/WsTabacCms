<?php


namespace App\Controller\webservices;


use App\Entity\Gouvernorat;
use App\Entity\ListInstallPdv;
use App\Entity\NewInstallPdv;
use App\Entity\NewInstallPdvComments;
use App\Entity\Quartier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route ;

/**
 * @Route ("api", name="api_")
 *
 */
class ListInstallPdvController extends MainController
{
    /**
     * @Rest\Get("/listinstallpdvbymerch/{id}/showall", name="list_install_pdv_show_all")
     * @return Response
     */
    public function index(int $id)
    {
        $data = $this->showListInstallPdvByMerchId($id);
        if (isset($data)) {
            return $this->successResponse($data);
        }else{ return $this->successResponse(["code"=>204,"message"=>"No Content"]);}
    }

    /**
     * @Rest\Get("/listinstallpdvbymerch/{id}/showallpagination", name="list__install_pdv_show_all_with_pagination")
     * @return Response
     */
    public function findNewInstallPdvWithPagination(Request $request,int $id)
    {

        $data = $this->showListInstallPdvByMerchId($id);
        if (!empty($data)) {
            $pagination = $this->paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                self::NUMBER_ITEM_PER_PAGE
            );
            return $this->successResponse($pagination);
        }else{ return $this->successResponse(["code"=>204,"message"=>"No Content"]);}


    }

    /**
     * Function to delete New Install From db when Refus Admin
     * @Rest\Delete("/listinstallpdvbymerch/{id}/delete", name="list__install_pdv_delete")
     */
    public  function delete(int $id)
    {
        $listInstallPdv = $this->em->getRepository(ListInstallPdv::class)->find($id);
        if (isset($listInstallPdv)) {
            $this->em->remove($listInstallPdv);
            $this->em->flush();
            return $this->successResponse(["code"=>200,"message"=>"OK"]);
        }else{ return $this->successResponse(["code"=>404,"message"=>"Not Found"]);}

    }

    /**
     * Created From (iPad) Part
     * id : id of the list
     * idComment : id of the comment
     * @Rest\Post("/listinstallpdv/{id}/accept/{idComment}/condition", name="new_install_pdv_comment_accept")
     * @param int $id
     * @return Response
     */
    public function accept(int $id, int $idComment)
    {
        $this->merchReponseOfAdminCondition($id,$idComment,1,0,1);
        return $this->successResponse(["code"=>200,"message"=>"Condition Accepted"]);
    }

    /**
     * Created From (iPad) Part
     * @Rest\Post("/listinstallpdv/{id}/refus/{idComment}/condition", name="new_install_pdv_comment_refus")
     * @param int $id
     * @return Response
     */
    public function refus(int $id, int $idComment)
    {
        $this->merchReponseOfAdminCondition($id,$idComment,1,0,-1);
        return $this->successResponse(["code"=>200,"message"=>"Condition Refused"]);
    }

    /**
     * Function To SET response of Merch of the condition sended by admin in the new install PDV
     * @param int $id
     * @param int $idComment
     * @param int $visibility
     * @param int $statusNewInstall
     * @param int $merchStatusComment
     * @param string $message
     * @return Response
     */
    private function merchReponseOfAdminCondition(int $id, int $idComment,int $visibility, int $statusNewInstall,int $merchStatusComment)
    {
        $newInstallPdvComment = $this->em->getRepository(NewInstallPdvComments::class)->find($idComment);
        $listInstallPdv = $this->em->getRepository(ListInstallPdv::class)->find($id);
        // Get The New Install PDV and Set Visibility To 1
        $newInstallPdvId = ($newInstallPdvComment->getNewInstallPdv())->getId();
        $newInstallPdv = $this->em->getRepository(NewInstallPdv::class)->find($newInstallPdvId);
        $newInstallPdv->setVisibility($visibility);
        $listInstallPdv->setStatusNewInstall($statusNewInstall);
        $newInstallPdvComment->setMerchStatusComment($merchStatusComment);
        $this->em->flush();
    }


    /**
     * Custom show List Install PDV (BO)
     * @param int $id
     * @return $data
     */
    private function showListInstallPdvByMerchId(int $id)
    {
        $listInstallPdvAll = $this->em->getRepository(ListInstallPdv::class)->customFindAllByMerch($id);
        foreach ($listInstallPdvAll as $listInstall) {
            $newInstallId =$listInstall->getNewInstallId();
            $titulaireNom = $listInstall->getTitulaireNom();
            $gouvernoratId = $listInstall->getGouvernoratId();
            $dateInstall= $listInstall->getInstallDay();
            $gouvernoratObject = $this->em->getRepository(Gouvernorat::class)->find($gouvernoratId);
            $quartierId = $listInstall->getQuartierId();
            $quartierObject = $this->em->getRepository(Quartier::class)->find($quartierId);
            $statusNewInstall = $listInstall->getStatusNewInstall();
            if($statusNewInstall == 0){
                $resultStatus = 0;
            }elseif ($statusNewInstall == 1){
                $resultStatus = 1;
            }elseif ($statusNewInstall == -1) {
                $resultStatus = 3;
            }else{$resultStatus = "-";}
            //if accepté a condition
            if ($statusNewInstall == 2) {
                $resultStatus = 2;
                $comment = $this->em->getRepository(NewInstallPdvComments::class)->customFind($newInstallId);
                //var_dump($comment);
                $commentId = $comment[0]["commentId"];
                $commentText = $comment[0]["comment"];
                $commentImage = $comment[0]["image"];

            }else{$commentId = null;$commentText = null;$commentImage= null;}

            $data[] = array(
                "id" => $listInstall->getId(),
                "code"=>$newInstallId,
                "nomClient"=>$titulaireNom,
                "gouvernorat"=>$gouvernoratObject->getLabel(),
                "quartier"=>$quartierObject->getLabel(),
                "status"=>$resultStatus,
                "commentId"=>$commentId,
                "commentText"=>$commentText,
                "image"=>$commentImage,
                "installDay"=>$dateInstall
            );
        }
        if(!empty($data)){ return $data;}else{ return null;}
    }




}