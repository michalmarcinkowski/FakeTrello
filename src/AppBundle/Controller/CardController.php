<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Card;

class CardController extends ResourceController
{
    /**
     * {@inherit}
     */
    public function createAction(Request $request)
    {
        $resource = $this->createNew();
        $form = $this->getForm($resource);

        $boardId = $request->get('boardId');
        $boardListId = $request->get('boardListId');

        if ($form->handleRequest($request)->isValid()) {
            $boardListRepository = $this->get('app.repository.board_list');
            $boardList = $boardListRepository->find($boardListId);
            $resource->setBoardList($boardList);
            $resource = $this->domainManager->create($resource);

            if ($this->config->isApiRequest()) {
                return $this->handleView($this->view($resource));
            }

            if (null === $resource) {
                return $this->redirectHandler->redirectToIndex();
            }

            return $this->redirectHandler->redirectTo($resource);
        }

        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('create.html'))
            ->setData(array(
                $this->config->getResourceName() => $resource,
                'form'                           => $form->createView(),
                'boardId'                        => $boardId,
                'boardListId'                    => $boardListId
            ))
        ;

        return $this->handleView($view);
    }

    public function moveAction($cardId, $targetBoardListId)
    {
        $boardListRepository = $this->get('app.repository.board_list');
        $boardList = $boardListRepository->find($targetBoardListId);
        $cardRepository = $this->get('app.repository.card');
        /** @var Card $card */
        $card = $cardRepository->find($cardId);
        $card->setBoardList($boardList);
        $entityManager = $this->container->get('doctrine')->getManager();
        /** @var EntityManagerInterface $entityManager */
        $entityManager->persist($card);
        $entityManager->flush();
        return $this->redirectHandler->redirectToReferer();
    }
}
