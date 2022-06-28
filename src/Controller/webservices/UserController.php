<?php
namespace App\Controller\webservices;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
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
class UserController  extends MainController
{
    /**
     * @Rest\Get("/users/showall",name = "users_show_all")
     */
    public function index()
    {

        $users = $this->em->getRepository(User::class)->findAll();
        if(isset($users)) {
            return $this->successResponse($users);
        }
    }

    /**
     * @Rest\Get("/users/showallpagination",name = "users_show_all_with_pagination")
     */
    public function allUsersWithPagination(Request $request)
    {

        $query = $this->em->getRepository(User::class)->findAllQuery();
        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            self::NUMBER_ITEM_PER_PAGE /*limit per page*/
        );
            return $this->successResponse($pagination);

    }

    /**
     * @Rest\Get("/users/{id}", name = "users_show_by_id", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $users = $this->em->getRepository(User::class)->find($id);
        if(isset($users)) {
            return $this->successResponse($users);
        }
    }

    /**
     * @Rest\Post("/users/create", name = "users_create")
     * @return Response
     */
    public function create( Request $request)
    {
          $data = json_decode($request->getContent(),true);
           // Check User if exist
           $user = $this->em->getRepository(User::class)->findOneBy([
               "email" => $data["email"],
           ]);

           if(!is_null($user))
           {
               return new Response ("User already exist", Response::HTTP_CONFLICT);
           }

           $user = new User();
           $user->setFirstName($data["first_name"]);
           $user->setLastName($data["last_name"]);
           $user->setEmail($data["email"]);
           $user->setUserNameAdmin($data["user_name_admin"]);
           $password = $data["password"];
           $user->setPassword(
               $this->passwordEncoder->encodePassword($user, $password)
           );
           $roles = $data["roles"];
           foreach ($roles as $role){
               $arr[]= $role["label"];
           }
           $user->setRoles($arr);
           $this->em->persist($user);
           $this->em->flush();
           return $this->successResponse($user);

    }


    /**
     * @Rest\Post("/users/{id}/update", name = "users_update", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function update(int $id, Request $request)
    {
        $data = json_decode($request->getContent(),true);
        $user = $this->em->getRepository(User::class)->find($id);
        if(isset($user)) {
            $user->setFirstName($data["first_name"] ?? $user->getFirstName());
            $user->setLastName($data["last_name"] ?? $user->getLastName());
            $user->setEmail($data["email"] ?? $user->getEmail());
            $user->setUserNameAdmin($data["user_name_admin"] ?? $user->getUserNameAdmin());
            $user->setPassword($this->passwordEncoder->encodePassword($user, $data["password"]) ?? $user->getPassword());
            $roles = $data["roles"];
            foreach ($roles as $role){
                $arr[]= $role["label"];
            }
            $user->setRoles($arr ?? $user->getRoles());
            $this->em->persist($user);
            $this->em->flush();
            return $this->successResponse($user);
        }
    }

    /**
     * @Rest\Delete("/users/{id}/delete", name = "users_delete", requirements = {"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $user = $this->em->getRepository(User::class)->find($id);
        if(isset($user)) {
            $this->em->remove($user);
            $this->em->flush();
            return $this->successResponse("deleted");
        }
    }

}