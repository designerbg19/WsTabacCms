<?php
namespace App\Controller\webservices;

use App\Entity\Commentaire;
use App\Entity\CommentaireType;
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
class CommentaireController extends MainController
{
    /**
     * @Rest\Get("/commentaires ",name = "commentaires _show_all")
     */
    public function index()
    {
        $commentaires  = $this->em->getRepository(Commentaire ::class)->findAll();
        $CommentaireType  = $this->em->getRepository(CommentaireType ::class)->findall();
        $com=[$commentaires,$CommentaireType];
        if(isset($com )) {
            return $this->successResponse($com );
        }
    }

    /**
     * @Rest\Get("/commentaires/{id}", name = "commentaires _show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $commentaires  = $this->em->getRepository(Commentaire ::class)->find($id);
        $CommentaireType  = $this->em->getRepository(CommentaireType ::class)->findall();
        $com=[$commentaires,$CommentaireType];
        if(isset($com )) {
            return $this->successResponse($com );
        }
    }

    /**
     * @Rest\Get("/commentaires/type/{type}", name = "commentaires _show_by_type")
     * @param $type
     * @return Response
     */
    public function showByType($type)
    {
        $commentaires  = $this->em->getRepository(Commentaire ::class)->findByType($type);

        if(isset($commentaires )) {
            return $this->successResponse($commentaires );
        }
    }

    /**
     * @Rest\Post("/commentaires", name = "commentaires _create")
     * @return Response
     */
    public function create( Request $request)
    {
        $commentaires  = new Commentaire ();
        $commentaires ->setText($request->request->get('commentText'));
        $commentaires->setTypeCommentaire($request->request->get('commentId'));

        $this->em->persist($commentaires );
        $this->em->flush();
        $commentaires_id=$commentaires->getId();
        if (http_response_code(200) == true) {
            return $this->successResponse([
                "code" => 200,
                "message" => "Commentaire Created ",
                "id_Commentaire"=> $commentaires_id
            ]);
        } else {
            if (http_response_code(500) == true) {
                return $this->successResponse(["message" => "erreur interne du serveur"]);
            } else {
                return $this->successResponse([http_response_code()]);
            }
        }
    }


    /**
     * @Rest\Post("/commentaires/{id}", name = "commentaires _update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $commentaires  = $this->em->getRepository(Commentaire ::class)->find($id);
        if(isset($commentaires )) {
            $commentaires ->setText($request->request->get('text') ?? $commentaires ->getText());
            $commentaires->setTypeCommentaire($request->request->get('type_coommentaire') ?? $commentaires->getTypeCommentaire());
            $this->em->persist($commentaires );
            $this->em->flush();
            return $this->successResponse($commentaires );
        }
    }

    /**
     * @Rest\Delete("/commentaires/{id}", name = "commentaires _delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $commentaires  = $this->em->getRepository(Commentaire ::class)->find($id);
        if(isset($commentaires )) {
            $this->em->remove($commentaires );
            $this->em->flush();
            return $this->successResponse($commentaires );
        }
    }

}