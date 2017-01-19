<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/*ANNOTATION AU DESSUS DE LA CLASS : VALABLE POUR TOUTE LA CLASS*/
/**
 * @Route("/admin/category")
 */

class AdminCategoryController extends Controller
{
    /**
     * @Route("/", name="app.admin.category.index")
     */
    public function indexAction(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();/*Tout sauf select*/
        $rc = $doctrine->getRepository('AppBundle:Category');/*select*/


        // replace this example code with whatever you need
        return $this->render('admin-category/index.html.twig', [
            'categ' => $rc->findAll()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app.admin.category.delete", requirements={"id" = "\d+"})
     */
    public function deleteAction(Request $request, $id)
    {

        //Service de gestion du formulaire
        $formHandler = $this->get('app.service.handler.formhandler');
        $formHandler->delete($id, 'AppBundle:Category' );

        $translate  = $this->get('translator');
        $delete     = $translate->trans('form.category.message.delete');

        $this->addFlash('success', $delete);

        return $this->redirectToRoute('app.admin.category.index');
    }

    /**
     * @Route("/form", name="app.admin.category.form")
     * @Route("/form/update/{id}", name="app.admin.category.form.update", requirements={"id" = "\d+"})
     */
    public function formAction(Request $request, $id=null)
    {
        /*$doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();//Tout sauf select
        $rc = $doctrine->getRepository('AppBundle:Category');//select*/

        // creation d'un formulaire : on a l'entité et la class du formulaire... recette de cuisine !
        $entity = $id ? $rc->find($id) : new Category();
        $entityType     = CategoryType::class;



        $form = $this->createForm($entityType, $entity);
        $form->handleRequest($request);//récupération de la saisie

        //Service de gestion du formulaire
        $formHandler = $this->get('app.service.handler.formhandler');

        if($formHandler->check($form)){
            $formHandler->process();
            $translate  = $this->get('translator');

            $add        = $id ? $translate->trans('form.category.message.update') : $translate->trans('form.category.message.ajout');
            $this->addFlash('success', $add);
            return $this->redirectToRoute('app.admin.category.index');
        }


        //envoi du formulaire sous forme de vue


        return $this->render('admin-category/form.html.twig', [
            'form'=>$form->createView()
        ]);
    }

}
