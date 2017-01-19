<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movie;
use AppBundle\Form\MovieType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/*ANNOTATION AU DESSUS DE LA CLASS : VALABLE POUR TOUTE LA CLASS*/
/**
 * @Route("/admin/movie")
 */

class AdminMovieController extends Controller
{
    /**
     * @Route("/", name="app.admin.movie.index")
     */
    public function indexAction(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();/*Tout sauf select*/
        $rc = $doctrine->getRepository('AppBundle:Movie');/*select*/


        // replace this example code with whatever you need
        return $this->render('admin-movie/index.html.twig', [
            'movies' => $rc->findAll()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app.admin.movie.delete", requirements={"id" = "\d+"})
     */
    public function deleteAction(Request $request, $id)
    {

        //Service de gestion du formulaire
        $formHandler = $this->get('app.service.handler.formhandler');
        $formHandler->delete($id, 'AppBundle:Movie' );

        $translate  = $this->get('translator');
        $delete     = $translate->trans('form.movie.message.delete');

        $this->addFlash('success', $delete);

        return $this->redirectToRoute('app.admin.movie.index');
    }

    /**
     * @Route("/form", name="app.admin.movie.form")
     * @Route("/form/update/{id}", name="app.admin.movie.form.update", requirements={"id" = "\d+"})
     */
    public function formAction(Request $request, $id=null)
    {
        $doctrine = $this->getDoctrine();

        $rc = $doctrine->getRepository('AppBundle:Movie');//select

        // creation d'un formulaire : on a l'entité et la class du formulaire... recette de cuisine !
        $entity = $id ? $rc->find($id) : new Movie();
        $entityType     = MovieType::class;



        $form = $this->createForm($entityType, $entity);
        $form->handleRequest($request);//récupération de la saisie

        //Service de gestion du formulaire
        $movieHandler = $this->get('app.service.handler.moviehandler');

        if($movieHandler->check($form)){

            $movieHandler->process();
            $translate  = $this->get('translator');

            $add        = $id ? $translate->trans('form.movie.message.update') : $translate->trans('form.movie.message.ajout');
            $this->addFlash('success', $add);
            return $this->redirectToRoute('app.admin.movie.index');
        }


        //envoi du formulaire sous forme de vue

        return $this->render('admin-movie/form.html.twig', [
            'form'=>$form->createView()
        ]);
    }

}
