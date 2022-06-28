<?php

namespace App\Controller\webservices;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
/**
 * @Route("/api", name="api_")
 */

class RegistrationController extends MainController
{
    /**
     * @Route("/register", name="registration", methods={"POST"})
     */
    public function index(Request $request)
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $user = $this->em->getRepository(User::class)->findOneBy([
            "email" => $email,
        ]);

        if(!is_null($user))
        {
            return new Response ("User already exists");
        }

        $user = new User();
        $user->setEmail($email);
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $password)
        );

        $this->em->persist($user);
        $this->em->flush();
        return new Response("User added");
    }

    /**
     * @Route("/register", name="users_show", methods={"GET"})
     */
    public  function show()
    {
        $users = $this->em->getRepository(User::class)->findAll();
        return $this->successResponse($users);
    }

    /**
     * @Route("/validator", name="validator", methods={"POST"})
     */
    public function index2()
    {
        return new Response("ggg");
    }
}
