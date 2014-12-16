<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;

class CommentBlameListener
{
    private $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function blameComment(GenericEvent $event)
    {
        $user = $this->securityContext->getToken()->getUser();
        $comment = $event->getSubject();
        $comment->setUser($user);
    }
}
