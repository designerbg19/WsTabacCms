<?php
namespace App\Controller\webservices;

use App\Entity\TypeClient;
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
class TypeClientController  extends MainController
{
    /**
     * @Rest\Get("/typeclient/showall", name="typeclient_show_all")
     */
    public function index()
    {
        $typeClient = $this->em->getRepository(TypeClient::class)->findType();
        if (isset($typeClient)) {
            return $this->successResponse($typeClient);
        }
    }

    /**
     * @Rest\Get("/typeclient/{id}", name="typeclient_show_by_id")
     * @return Response
     */
    public function show(int $id)
    {
        $typeClient = $this->em->getRepository(TypeClient::class)->find($id);
        if (isset($typeClient)) {
            return $this->successResponse($typeClient);
        }
    }

    /**
     * @Rest\Post("/typeclient/create", name="typeclient_create")
     * @return Response
     */
    public function create(Request $request)
    {
        $typeClient = new  TypeClient();
        $typeClient->setType($request->request->get("type"));
        $this->em->persist($typeClient);
        $this->em->flush();
        return $this->successResponse(["id"=>$typeClient->getId(),"label"=>$typeClient->getType()]);
    }

    /**
     * @Rest\Post("/typeclient/{id}/update", name="typeclient_update")
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $typeClient = $this->em->getRepository(TypeClient::class)->find($id);
        if(isset($typeClient)) {
            $typeClient->setType($request->request->get("type") ?? $typeClient->getLabel());
            $this->em->persist($typeClient);
            $this->em->flush();
            return $this->successResponse(["id"=>$typeClient->getId(),"label"=>$typeClient->getType()]);
        }
    }

    /**
     * @Rest\Delete("/typeclient/{id}/delete",name="typeclient_delete")
     */
    public function delete(Request $request, int $id)
    {
        $typeClient = $this->em->getRepository(TypeClient::class)->find($id);
        if (isset($typeClient)) {
            $this->em->remove($typeClient);
            $this->em->flush();
            return $this->successResponse(["code"=>200,"message"=>"Ok"]);
        }
    }

}