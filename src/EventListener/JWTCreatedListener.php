<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;


class JWTCreatedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var $user \AppBundle\Entity\User */
        $user = $event->getUser();

        $roles =$user->getRoles();
        if (in_array("ROLE_MERCH", $roles))
        {
            $payload['merchId'] = $user->getId();
            $payload['username'] = $user->getUsername();
        }
        else{
            // add new data
            $payload['user_id'] = $user->getId();
            $payload['username'] = $user->getUsername();
            $payload['first_name'] = $user->getFirstName();
            $payload['last_name'] = $user->getLastName();
            $payload['fullname'] = $user->getUserNameAdmin();
            $payload['roles'] = $user->getRoles();
        }


        $event->setData($payload);
    }
}