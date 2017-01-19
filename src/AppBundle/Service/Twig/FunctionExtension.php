<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 19/12/16
 * Time: 12:50
 */

namespace AppBundle\Service\Twig;


use AppBundle\Service\Panier\PanierService;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class FunctionExtension extends \Twig_Extension
{
    private $twig;
    private $locales;
    private $request;
    private $router;
    private $panierService;
    public function __construct(\Twig_Environment $twig, $locales, RequestStack $request, Router $router, PanierService $panierService)
    {
        $this->twig = $twig;
        $this->locales = $locales;
        $this->request = $request->getMasterRequest();
        $this->router = $router;
        $this->panierService = $panierService;
    }

    /*CE SERVICE SERT A RAJOUTER UNE FONCTION A TWIG*/
    public function getFunctions()
    {/*premier parametre : comment on l'appelle dans twig, deuxieme : le vrai nom de la fonction définie juste après*/
        return [
            new \Twig_SimpleFunction('render_locales', [$this, 'renderLocales']),
            new \Twig_SimpleFunction('get_all_prices', [$this, 'getAllPrices'])
        ];
    }

    public function renderLocales(){
        $route = $this->request->get('_route');
        $routeparams = $this->request->get('_route_params');
//        dump($route, $routeparams);

//        |merge({'_locale': 'fr'})

        $routes = array();
        foreach($this->locales as $locales) {
            $routes[$locales] = $this->router->generate($route, array_merge($routeparams, array("_locale"=>$locales)));
        }

        return $this->twig->render('inc\render\locales.html.twig', [
            'routes' => $routes
        ]);
    }

    public function getAllPrices(){
        return $totalPanier = $this->panierService->totalPanierPrice();

    }



}