<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="app.homepage.index")
     */
    public function indexAction(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();/*Tout sauf select*/
        $rc = $doctrine->getRepository('AppBundle:Movie');/*select*/
        $rcAct = $doctrine->getRepository('AppBundle:Actor');/*select*/


        // replace this example code with whatever you need
        return $this->render('homepage/index.html.twig', [
            'movies' => $rc->findAll(),
            'actors' => $rcAct->getActors()
        ]);
    }

}
