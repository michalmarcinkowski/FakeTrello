<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Organization;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Board;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BoardListController extends ResourceController
{
    public function allForBoardAction($boardId)
    {
        $resource = $this->createNew();
        $form = $this->getForm($resource);

        /** @var Board $board */
        $board = $this->getOr404($this->get('app.repository.board'), $boardId);
        if (!$this->canDisplayBoard($board)) {
            throw new AccessDeniedException("Your not allowed to display this board!");
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setData(array(
                $this->config->getPluralResourceName() => $board->getLists(),
                'form'                                 => $form->createView(),
                'board'                                => $board
            ))
        ;

        return $this->handleView($view);
    }

    private function canDisplayBoard(Board $board)
    {
        $user = $board->getUser();
        if (!empty($user)) {
            return ($this->getUser()->getId() === $user->getId());
        }
        $organization = $board->getOrganization();
        if (!empty($organization)) {
            return ($this->isOrganizationMember($organization));
        }
        return false;
    }

    private function isOrganizationMember(Organization $organization)
    {
        foreach ($this->getUser()->getOrganizations() as $userOrganization) {
            if ($organization->getId() === $userOrganization->getId()) {
                return true;
            }
        }
        return false;
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
