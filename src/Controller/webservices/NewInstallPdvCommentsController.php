<?php


namespace App\Controller\webservices;

use App\Entity\NewInstallPdvComments;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route ;

/**
 * @Route ("api", name="api_")
 *
 */
class NewInstallPdvCommentsController extends MainController
{
    /**
     * @Rest\Get("/newinstallpdvcomments/showall", name="new_install_pdv_comments_show_all")
     * @return Response
     */
    public function index()
    {
        $newInstallPdvComments = $this->em->getRepository(NewInstallPdvComments::class)->findAll();
        if (isset($newInstallPdvComments)) {
            return $this->successResponse($newInstallPdvComments);
        }
    }

}