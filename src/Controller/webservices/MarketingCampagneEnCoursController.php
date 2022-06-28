<?php
namespace App\Controller\webservices;

use App\Entity\MarketingCampagneEnCours;
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
class MarketingCampagneEnCoursController extends MainController
{
    /**
     * @Rest\Get("/mcampagneencours/showall", name="mcampagneencours_show_all")
     */
    public function index()
    {
        // var Marketing Campagne en Cours
        $mCampagneEnCours = $this->em->getRepository(MarketingCampagneEnCours::class)->findall();
        if(isset($mCampagneEnCours)) {
            return $this->successResponse($mCampagneEnCours);
        }
    }
    
    /**
     * @Rest\Get("/mcampagneencours/{id}", name="mcampagneencours_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $mCampagneEnCours = $this->em->getRepository(MarketingCampagneEnCours::class)->find($id);
        if(isset($mCampagneEnCours)) {
            return $this->successResponse($mCampagneEnCours);
        }
    }

    /**
     * @Rest\Post("/mcampagneencours/create", name="mcampagneencours_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $mCampagneEnCours = new  MarketingCampagneEnCours();
        $mCampagneEnCours->setLabel($request->request->get("label"));
        $this->em->persist($mCampagneEnCours);
        $this->em->flush();
        return $this->successResponse($mCampagneEnCours);
    }

    /**
     * @Rest\Post("/mcampagneencours/{id}/update", name="mcampagneencours_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $mCampagneEnCours = $this->em->getRepository(MarketingCampagneEnCours::class)->find($id);
        if(isset($mCampagneEnCours)){
            $mCampagneEnCours->setLabel($request->request->get("label") ?? $mCampagneEnCours->getLabel());
            $this->em->persist($mCampagneEnCours);
            $this->em->flush();
            return $this->successResponse($mCampagneEnCours);
        }
    }

    /**
     * @Rest\Delete("/mcampagneencours/{id}/delete",name="mcampagneencours_delete")
     */
    public  function delete(Request $request, int $id)
    {
        $mCampagneEnCours = $this->em->getRepository(MarketingCampagneEnCours::class)->find($id);
        if(isset($mCampagneEnCours)) {
            $this->em->remove($mCampagneEnCours);
            $this->em->flush();
            return $this->successResponse($mCampagneEnCours);
        }
    }

}