<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class DOSCGController extends AbstractActionController
{
    public function sequenceAction() {
        return new JsonModel(['message' => 'hello there!']);
    }
}
