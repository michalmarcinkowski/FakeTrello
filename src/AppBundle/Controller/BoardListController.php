<?php

namespace AppBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

class BoardListController extends ResourceController
{
    public function allForBoardAction($boardId)
    {
        $resource = $this->createNew();
        $form = $this->getForm($resource);

        $boardRepository = $this->get('app.repository.board');
        $board = $boardRepository->find($boardId);

        $criteria = array('board' => $board);
        $repository = $this->getRepository();
        $resources = $repository->findBy($criteria);

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setData(array(
                $this->config->getPluralResourceName() => $resources,
                'form'                                 => $form->createView(),
                'board'                                => $board
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * {@inherit}
     */
    public function createAction(Request $request)
    {
        $resource = $this->createNew();
        $form = $this->getForm($resource);

        $boardId = $request->get('boardId');

        if ($form->handleRequest($request)->isValid()) {
            $boardRepository = $this->get('app.repository.board');
            $board = $boardRepository->find($boardId);
            $resource->setBoard($board);
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
                'boardId'                        => $boardId
            ))
        ;

        return $this->handleView($view);
    }
}
