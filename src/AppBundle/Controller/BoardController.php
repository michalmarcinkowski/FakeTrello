<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

class BoardController extends ResourceController
{
    public function allForUserAction()
    {
        $resource = $this->createNew();
        $form = $this->getForm($resource);

        $currentUser = $this->getUser();

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setData(array(
                'user' => $currentUser,
                'form' => $form->createView(),
            ))
        ;

        return $this->handleView($view);
    }

    public function starAction(Request $request)
    {
        $board = $this->findOr404($request);
        $user = $this->getUser();
        $user->addStarredBoard($board);
        $entityManager = $this->container->get('doctrine')->getManager();
        /** @var EntityManagerInterface $entityManager */
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectHandler->redirectToReferer();
    }

    public function unstarAction(Request $request)
    {
        $board = $this->findOr404($request);
        $user = $this->getUser();
        $user->removeStarredBoard($board);
        $entityManager = $this->container->get('doctrine')->getManager();
        /** @var EntityManagerInterface $entityManager */
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectHandler->redirectToReferer();
    }
}
