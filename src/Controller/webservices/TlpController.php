<?php
namespace App\Controller\webservices;

use App\Entity\Tlp;
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

class TlpController extends MainController
{
    /**
     * @Rest\Get("/tlp/showall", name="tlp_show")
     * @return Response
     */
    public function index()
    {
        $tlp = $this->em->getRepository(Tlp::class)->findAll();
        if (isset($tlp)) {
            return $this->successResponse($tlp);
        }
    }

    /**
     * @Rest\Get("/tlp/{id}", name="tlp_show_by_id")
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $tlp = $this->em->getRepository(Tlp::class)->find($id);
        if (isset($tlp)) {
            return $this->successResponse($tlp);
        }
    }

    /**
     * @Rest\Post("/tlp/create", name="tlp_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $tlp = new Tlp();
        $isPlanograme = $request->request->get("planograme");
        $isEclairage = $request->request->get("eclairage");
        $tlp->setPlanogramme($isPlanograme);
        $tlp->setEclairage($isEclairage);
        $tlp->setBonus(0);
        if($isPlanograme == true and $isEclairage == true){
            $tlp->setScore($tlp->getBonus()+2);
        }elseif ($isPlanograme == false and $isEclairage == false){
            $tlp->setScore($tlp->getBonus());
        }else{
            $tlp->setScore($tlp->getBonus()+1);
        }
        $this->em->persist($tlp);
        $this->em->flush();
        return $this->successResponse($tlp);
    }

    /**
     * @Rest\Post("/tlp/{id}/update", name="tlp_update")
     * @param int $id
     * @return Response
     */
    public function update(Request $request,int $id)
    {
        $tlp = $this->em->getRepository(tlp::class)->find($id);
        $bonus = $request->request->get("bonus")+ $tlp->getBonus();
        if(isset($tlp)) {
            $tlp->setBonus($bonus);
            $tlp->setScore($tlp->getScore()+$bonus);
            $this->em->persist($tlp);
            $tlp->setBonus(0);
            $this->em->flush();
            return $this->successResponse($tlp);
        }
    }

    /**
     * @Rest\delete("/tlp/{id}/delete", name="tlp_delete")
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, int $id)
    {
        $tlp = $this->em->getRepository(Tlp::class)->find($id);
        if(isset($tlp)) {
            $this->em->remove($tlp);
            $this->em->flush();
            return $this->successResponse($tlp);
        }
    }

}