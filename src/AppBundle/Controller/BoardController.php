<?php

namespace AppBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;

class BoardController extends ResourceController
{
    public function allForUserAction()
    {
        $currentUser = $this->getUser();

        $repository = $this->getRepository();

        $criteria = array('user' => $currentUser);

        $resources = $repository->findBy($criteria);

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData($resources)
        ;

        return $this->handleView($view);
    }
}
