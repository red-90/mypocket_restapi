<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Operation;

class OperationController extends Controller
{
    /**
     * @Route("/operations", name="operation_list")
     * @Method({"GET"})
     */
    public function getOperationsAction(Request $request)
    {
        $operations = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Operation')
                ->findAll();
        /* @var $operations Operations[] */

        $formatted = [];
        foreach ($operations as $operation) {
            $formatted[] = [
               'id' => $operation->getId(),
               'name' => $operation->getName(),
               'type' => $operation->getType(),
               'price' => $operation->getPrice(),
               'category' => $operation->getCategory(),
               'description' => $operation->getDescription(),
            ];
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Route("/operations/{operation_id}", requirements={"operation_id" = "\d+"}, name="operation_one")
     * @Method({"GET"})
     */
    public function getOperationAction(Request $request)
    {
        $operation = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Operation')
                ->find($request->get('operation_id'));
        /* @var $operation Operation */

        if (empty($operation)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        $formatted = [
           'id' => $operation->getId(),
           'name' => $operation->getName(),
           'type' => $operation->getType(),
           'price' => $operation->getPrice(),
           'category' => $operation->getCategory(),
           'description' => $operation->getDescription(),
        ];

        return new JsonResponse($formatted);
    }
}