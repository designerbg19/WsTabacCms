<?php
namespace App\Controller\webservices;

use App\Entity\Cycle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/api", name="api_")
     *
     */
class CycleController extends MainController
{


    /**
     *
     * @Rest\Get("/cycles/showall",name = "cycle_show_all")
     */
    public function index()
    {
        $cycle = $this->em->getRepository(Cycle::class)->findAll();
        if(isset($cycle)) {
            return $this->successResponse($cycle);
        }
    }


    /**
     * @Rest\Get("/cycles/showWithPagination",name = "cycle_show_all_with_pagination")
     */
    public function showCyclesWithPagination(Request $request)
    {
        $query = $this->em->getRepository(Cycle::class)->findAllQuery();
        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            self::NUMBER_ITEM_PER_PAGE /*limit per page*/
        );
        return $this->successResponse($pagination);
    }

    /**
     * @Rest\Get("/cycle/{id}", name = "cycle_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $cycle = $this->em->getRepository(Cycle::class)->find($id);
        if(isset($cycle)) {
            return $this->successResponse($cycle);
        }
    }

    /**
     * @Rest\Get("/cycle/num/{num}", name = "cycle_show_by_numero", requirements = {"id"="\d+"})
     * @param int $num
     * @return Response
     */
    public function showByNumCycle(int $num)
    {
        $cycle = $this->em->getRepository(Cycle::class)->findByNumero($num);
        if(isset($cycle)) {
            return $this->successResponse($cycle);
        }
    }

    /**
     * @Rest\Post("/cycle/create", name = "cycle_create")
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        foreach ($data as $item){
            $cycle = new cycle();
            $cycle->setDateDebut(new \DateTime($item["date_debut"]));
            $cycle->setDateFin(new \DateTime($item["date_fin"]));
            $cycle->setNumCycle($item["num_cycle"]);
            // Default = 0: (cyle = planning not validated yet)
            $cycle->setValid(0);
            $this->em->persist($cycle);
            $this->em->flush();
        }
        return $this->successResponse("Cycles Created.");
    }

    /**
     * @Rest\Post("/cycle/{id}/update", name = "cycle_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     *//*
    public function update(int $id, Request $request)
    {
        $cycle = $this->em->getRepository(Cycle::class)->find($id);
        if(isset($cycle)) {
            $cycle->setDateDebut(new \DateTime($request->request->get('date_debut')) ?? $cycle->getDateDebut());
            $cycle->setDateFin(new \DateTime($request->request->get('date_fin')) ?? $cycle->getDateFin());
            $cycle->setNumCycle($request->request->get('num_cycle') ?? $cycle->getNumCycle());
            $this->em->persist($cycle);
            $this->em->flush();
            return $this->successResponse($cycle);
        }
    }*/

    /**
     * @Rest\Delete("/cycle/{id}", name = "cycle_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $cycle = $this->em->getRepository(Cycle::class)->find($id);
        if(isset($cycle)) {
            $this->em->remove($cycle);
            $this->em->flush();
            return $this->successResponse($cycle);
        }
    }

}