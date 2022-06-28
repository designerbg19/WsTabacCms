<?php
namespace App\Controller\webservices;

use App\Entity\PdvClasses;
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
class PdvClassesController extends MainController
{
    /**
     * @Rest\Get("/pdvclasses/showall", name="pdvclasses_show_all")
     */
    public function index()
    {
        $pdvClasses = $this->em->getRepository(PdvClasses::class)->findall();
        if (isset($pdvClasses)) {
            return $this->successResponse($pdvClasses);
        }
    }

    /**
     * @Rest\Get("/pdvclasses/{id}", name="pdvclasses_show_by_id")
     * @return Response
     *
     */
    public function show(int $id)
    {
        $pdvClasses = $this->em->getRepository(PdvClasses::class)->find($id);
        if (isset($pdvClasses)) {
            return $this->successResponse($pdvClasses);
        }
    }

    /**
     * @Rest\Post("/pdvclasses/create", name="pdvclasses_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $pdvClasses = new  PdvClasses();
        $pdvClasses->setLabel($request->request->get("label"));
        $this->em->persist($pdvClasses);
        $this->em->flush();
        return $this->successResponse($pdvClasses);
    }

    /**
     * @Rest\Post("/pdvclasses/{id}/update", name="pdvclasses_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $pdvClasses = $this->em->getRepository(PdvClasses::class)->find($id);
        if(isset($pdvClasses)) {
            $pdvClasses->setLabel($request->request->get("label") ?? $pdvClasses->getLabel());
            $this->em->persist($pdvClasses);
            $this->em->flush();
            return $this->successResponse($pdvClasses);
        }
    }

    /**
     * @Rest\Delete("/pdvclasses/{id}/delete",name="pdvclasses_delete")
     */
    public function delete(Request $request, int $id)
    {
        $pdvClasses = $this->em->getRepository(PdvClasses::class)->find($id);
        if (isset($pdvClasses)) {
            $this->em->remove($pdvClasses);
            $this->em->flush();
            return $this->successResponse($pdvClasses);
        }
    }

}