<?php


namespace App\Controller\webservices;


use App\Entity\DateRouting;
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
class DateRoutingController extends MainController
{
    /**
     * @Rest\Get("/daterouting/schowall",name = "dateRouting_show_all")
     */
    public function index()
    {
        $dateRouting = $this->em->getRepository(DateRouting::class)->findAll();
        if(isset($dateRouting)) {
            return $this->successResponse($dateRouting);
        }
    }

    /**
     * @Rest\Get("/daterouting/{id}", name = "dateRouting_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $dateRouting = $this->em->getRepository(DateRouting::class)->find($id);
        if(isset($dateRouting)) {
            return $this->successResponse($dateRouting);
        }

    }

    /**
     * @Rest\Post("/daterouting", name = "dateRouting_create")
     * @return Response
     */
    public function create( $data)
    {
        $dateRouting = new DateRouting();
        $dateRouting->setDateDebut(new \DateTime($data["date_debut"]));
        $dateRouting->setDateFin(new \DateTime($data["date_fin"]));
        $this->em->persist($dateRouting);
        $this->em->flush();
        return $dateRouting->getId();
        //return $dateRouting;
    }

    /**
     * @Rest\Post("/daterouting/{id}", name = "dateRouting_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $dateRouting = $this->em->getRepository(DateRouting::class)->find($id);
        if(isset($dateRouting)) {
            $dateRouting->setlabel($request->request->get('label') ?? $dateRouting->getLabel());
            $this->em->persist($dateRouting);
            $this->em->flush();
            return $this->successResponse($dateRouting);
        }
    }

    /**
     * @Rest\Delete("/daterouting/{id}", name = "dateRouting_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $dateRouting = $this->em->getRepository(DateRouting::class)->find($id);
        if(isset($dateRouting)) {
            $this->em->remove($dateRouting);
            $this->em->flush();
            return $this->successResponse($dateRouting);
        }
    }

}