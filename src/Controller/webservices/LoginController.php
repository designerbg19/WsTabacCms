<?php


namespace App\Controller\webservices;


use App\Entity\Merch;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * @Route ("api", name="api_")
 *
 */
class LoginController extends MainController
{
    /**
     * @Rest\Post("/login_merch", name="login_merch")
     * @return Response
     */
    public function loginMerch(Request $request)
    {
        $codeMerch = $request->request->get('code_merch');
        $password = $request->request->get('password');
       $merch = $this->em->getRepository(Merch::class)->findOneBy([
            'codeMerch'=>(int)$codeMerch
        ]);

        if(isset($merch)){
            $isValidPassword = password_verify($password,$merch->getPassword());
            if($isValidPassword){
                 return  $this->successResponse(array('message'=>'welcome '.$merch->getNom().' '.$merch->getPrenom().' ','merch_id'=>$merch->getId()));
            }else{
                 return  $this->successResponse('Invalid Password');
            }
        }
        return  $this->successResponse('Invalid Username');

    }




}