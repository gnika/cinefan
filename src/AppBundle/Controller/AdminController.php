<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/*ANNOTATION AU DESSUS DE LA CLASS : VALABLE POUR TOUTE LA CLASS*/
/**
 * @Route("/admin")
 */

class AdminController extends Controller
{
    /**
     * @Route("/", name="app.admin.index")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('admin/index.html.twig', [

        ]);
    }

}
