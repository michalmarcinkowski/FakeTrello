<?php

namespace AppBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

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
}
