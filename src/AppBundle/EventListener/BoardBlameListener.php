<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;

class BoardBlameListener
{
    private $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function blameBoard(GenericEvent $event)
    {
        $user = $this->securityContext->getToken()->getUser();
        $board = $event->getSubject();
        $organization = $board->getOrganization();
        if (empty($organization)) {
            $board->setUser($user);
        }
    }
}
