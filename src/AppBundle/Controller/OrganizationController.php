<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class OrganizationController extends ResourceController
{
    public function addBoardAction()
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
}
