<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Card;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $boardList = $this->getOr404($this->get('app.repository.board_list'), $targetBoardListId);
        /** @var Card $card */
        $card = $this->getOr404($this->get('app.repository.card'), $cardId);
        $card->setBoardList($boardList);
        $entityManager = $this->container->get('doctrine')->getManager();
        /** @var EntityManagerInterface $entityManager */
        $entityManager->persist($card);
        $entityManager->flush();
        return $this->redirectHandler->redirectToReferer();
    }

    public function getOr404(RepositoryInterface $repository, $id)
    {
        $object = $repository->find($id);
        if (!empty($object)) {
            return $object;
        }
        $position = strrpos($repository->getClassName(), '\\');
        if (!$position) {
            $position = -1;
        }
        throw new NotFoundHttpException(
            sprintf(
                "Requested %s with id '%d' does not exist.",
                substr($repository->getClassName(), $position + 1),
                $id)
            );
    }
}
