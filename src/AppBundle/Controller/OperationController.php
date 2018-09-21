<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use AppBundle\Form\Type\OperationType;
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

        if (empty($operation)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Operation not found'], Response::HTTP_NOT_FOUND);
        }

        return $operation;
    }

  /**
   * @Rest\View()
   * @Rest\Get("/operations-bydate")
   */
  public function getOperationsByDateAction(Request $request)
  {
    $operations = $this->get('doctrine.orm.entity_manager')
      ->getRepository('AppBundle:Operation')
      ->getOperationsByDate();

    return $operations;
  }


    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/operations")
     */
    public function postOperationsAction(Request $request)
    {
        $operation = new Operation();

        $form = $this->createForm(OperationType::class, $operation);

        $form->submit($request->request->all()); // Validation des données
        if ($form->isValid()) {
          $em = $this->get('doctrine.orm.entity_manager');
          $em->persist($operation);
          $em->flush();
          return $operation;
        }else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/operations/{id}")
     */
    public function removeOperationAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $operation = $em->getRepository('AppBundle:Operation')
                    ->find($request->get('id'));
        /* @var $place Place */

        if ($operation) {
            $em->remove($operation);
            $em->flush();
        }
    }

       /**
     * @Rest\View()
     * @Rest\Put("/operations/{id}")
     */
    public function updateOperationAction(Request $request)
    {
        return $this->updateOperation($request, true);
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/operations/{id}")
     */
    public function patchOperationAction(Request $request)
    {
        return $this->updateOperation($request, false);
    }

    private function updateOperation(Request $request, $clearMissing)
    {
        $operation = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Operation')
                ->find($request->get('id')); 

        if (empty($operation)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Operation not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(OperationType::class, $operation);

        // Le paramètre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($operation);
            $em->flush();
            return $operation;
        } else {
            return $form;
        }
    }
}