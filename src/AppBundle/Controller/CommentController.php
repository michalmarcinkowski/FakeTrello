<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Organization;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Board;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CommentController extends ResourceController
{
    /**
     * {@inherit}
     */
    public function createAction(Request $request)
    {
        $resource = $this->createNew();
        $form = $this->getForm($resource);

        $cardId = $request->get('id');

        if ($form->handleRequest($request)->isValid()) {
            $cardRepository = $this->get('app.repository.card');
            $card = $cardRepository->find($cardId);
            $resource->setCard($card);
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
                'boardId'                        => $cardId
            ))
        ;

        return $this->handleView($view);
    }
}
