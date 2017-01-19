<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 28/12/16
 * Time: 09:44
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;
use Symfony\Component\HttpFoundation\Request;


class PanierController extends Controller
{
    /**
     * @Route("/panier", name="app.panier.index")
     */
    public function indexAction(Request $request)
    {
        $panier = $this->get('session');
        $panier = $panier->get('panier');
        $doctrine = $this->getDoctrine();
        $rc = $doctrine->getRepository('AppBundle:Movie');
        if(count($panier)>0) {
            $arrayKeyMovies = array_keys($panier);
            $movies = $rc->getMoviesByIds($arrayKeyMovies);

            $panierService = $this->get('app.service.panier.panierService');
            $totalPrice = $panierService->pricesPanier($movies);
        }else{
            $movies=new \stdClass();
            $totalPrice=[];
        }




        return $this->render('panier/index.html.twig', [
            'movies' =>$movies,
            'totalPricePerProduct' => $totalPrice,
            'totalPrice' => array_sum($totalPrice)
        ]);
    }
}