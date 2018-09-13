<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use AppBundle\Entity\Operation;

class OperationController extends Controller
{

     /**
     * @Rest\View()
     * @Rest\Get("/operations")
     */
    public function getOperationsAction(Request $request)
    {
        $operations = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Operation')
                ->findAll();

        return $operations;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/operations/{id}")
     */
    public function getOperationAction(Request $request)
    {
        $operation = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Operation')
                ->find($request->get('id'));
        /* @var $operation Operation */

        if (empty($operation)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        return $operation;

    }
}