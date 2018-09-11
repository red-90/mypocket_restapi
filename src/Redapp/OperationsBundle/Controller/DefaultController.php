<?php

namespace Redapp\OperationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@RedappOperations/Default/index.html.twig');

    }
}
