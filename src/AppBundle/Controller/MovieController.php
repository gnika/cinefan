<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends Controller
{
    /**
     * @Route("/movie/detail/{id}/{slug}", name="app.movie.detail", requirements={"id" = "\d+", "slug" = "\D+"})
     */
    public function detailAction(Request $request,  $id = null, $slug = null)
    {
        $doctrine = $this->getDoctrine();
        $rc = $doctrine->getRepository('AppBundle:Movie');



        // replace this example code with whatever you need
        return $this->render('movie/detail.html.twig', [
            'movie' => $rc->find($id)
        ]);
    }
    /**
     * @Route("/movie/buy/{id}/{quantity}", name="app.movie.buy", requirements={"id" = "\d+"})
     */
    public function buyAction(Request $request,  $id = null, $quantity = 1)
    {


        $doctrine = $this->getDoctrine();
        $rc = $doctrine->getRepository('AppBundle:Movie');

        $panierService = $this->get('app.service.panier.panierService');
        $quantityFinalProduct = $panierService->addPanier($id, $quantity);

        echo $quantityFinalProduct;
        die();
    }
}