<?php

namespace AppBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;

class BoardController extends ResourceController
{
    public function allForUserAction()
    {
        $resource = $this->createNew();
        $form = $this->getForm($resource);

        $currentUser = $this->getUser();
        $criteria = array('user' => $currentUser);

        $repository = $this->getRepository();
        $resources = $repository->findBy($criteria);

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setData(array(
                $this->config->getPluralResourceName() => $resources,
                'form'                                 => $form->createView(),
            ))
        ;

        return $this->handleView($view);
    }
}
