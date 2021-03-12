<?php


namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class StaticController extends AbstractActionController
{
    public function staticAction() {
        $page = $this->params()->fromRoute('page', 'about');
        return new ViewModel([
            'page'  => $page,
        ]);
    }


}