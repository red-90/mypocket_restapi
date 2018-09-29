<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use AppBundle\Form\Type\CategoryType;
use AppBundle\Entity\Category;

class CategoryController extends Controller
{

     /**
     * @Rest\View()
     * @Rest\Get("/api/categories")
     */
    public function getCategoriesAction(Request $request)
    {
        $categories = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Category')
                ->findAll();

        return $categories;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/api/categories/{id}")
     */
    public function getCategoryAction(Request $request)
    {
        $category = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Category')
                ->find($request->get('id'));

        if (empty($category)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        return $category;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/api/categories")
     */
    public function postCategoriesAction(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->submit($request->request->all()); // Validation des données
        if ($form->isValid()) {
          $em = $this->get('doctrine.orm.entity_manager');
          $em->persist($category);
          $em->flush();
          return $category;
        }else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/api/categories/{id}")
     */
    public function removeCategoryAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $category = $em->getRepository('AppBundle:Category')
                    ->find($request->get('id'));

        if ($category) {
            $em->remove($category);
            $em->flush();
        }
    }

       /**
     * @Rest\View()
     * @Rest\Put("/api/categories/{id}")
     */
    public function updateCategoryAction(Request $request)
    {
        return $this->updateCategory($request, true);
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/api/categories/{id}")
     */
    public function patchCategoryAction(Request $request)
    {
        return $this->updateCategory($request, false);
    }

    private function updateCategory(Request $request, $clearMissing)
    {
        $category = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Category')
                ->find($request->get('id')); 

        if (empty($category)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(CategoryType::class, $category);

        // Le paramètre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($category);
            $em->flush();
            return $category;
        } else {
            return $form;
        }
    }
}