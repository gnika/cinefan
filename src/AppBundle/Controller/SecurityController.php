<?php
// src/AppBundle/Controller/SecurityController.php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="app.security.login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    /**
     * @Route("/logout", name="app.security.logout")
     */
    public function logoutAction(Request $request)
    {

    }

    /**
     * @Route("/account", name="app.security.account")
     */
    public function accountAction(Request $request)
    {
        $doctrine = $this->getDoctrine();

        $rc = $doctrine->getRepository('AppBundle:User');//select

        // creation d'un formulaire : on a l'entité et la class du formulaire... recette de cuisine !
        $entity = new User();
        $entityType     = UserType::class;



        $form = $this->createForm($entityType, $entity);
        $form->handleRequest($request);//récupération de la saisie

        $formHandler = $this->get('app.service.handler.userhandler');

        if($formHandler->check($form)){

            $formHandler->process();
            $translate  = $this->get('translator');

            $add        = $translate->trans('form.user.ajout');
            $this->addFlash('success', $add);
            return $this->redirectToRoute('app.homepage.index');
        }



        //envoi du formulaire sous forme de vue

        return $this->render('security/form.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}