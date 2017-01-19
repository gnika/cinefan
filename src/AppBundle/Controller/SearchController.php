<?php

namespace AppBundle\Controller;

use AppBundle\Form\MovieSearch;
use AppBundle\Form\MovieSearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SearchController extends Controller
{
    /**
     * @Route("/search", name="app.search.index")
     */
    public function indexAction(Request $request)
    {
        $searchSimple = $request->get('search');

//        dump($request->request->get('appbundle_movie_search')['title']); exit;

        $doctrine = $this->getDoctrine();
        $rc = $doctrine->getRepository('AppBundle:Movie');/*select*/

        if($searchSimple!='')
            $param = $rc->getMovieByTitle($searchSimple);
        else
            $param ='';

        // retourne le résultat du formulaire ici :
        return $this->render('search/index.html.twig', [
            'movies' => $param
        ]);
    }

    /**
     * @Route("/search/advanced", name="app.search.advanced")
     */
    public function searchAction(Request $request)
    {
        $title = $request->get('search');

        // creation d'un formulaire : sans entité car c'est un formulaire non attaché
        $entityType     = MovieSearchType::class;


        $form = $this->createForm($entityType, null, [
            'action' => $this->generateUrl("app.search.advanced")
        ]);
        $form->handleRequest($request);//récupération de la saisie


        //envoi du formulaire sous forme de vue

        $doctrine = $this->getDoctrine();

        $rc = $doctrine->getRepository('AppBundle:Movie');/*select*/

        if(count($request->request->get('appbundle_movie_search'))>0)
            $param = $rc->getMovies($request->request->get('appbundle_movie_search'));
        else
            $param = $rc->findAll();

        return $this->render('search/form.html.twig', [
            'form'=>$form->createView(),
            'movies' => $param
        ]);
    }

    /**
     * @Route("/search/ajax", name="app.search.ajax")
     */
    public function ajaxAction(Request $request)
    {
        $actorName = $request->get('noms');
    //dump($actorName);

        $doctrine = $this->getDoctrine();
        $rc = $doctrine->getRepository('AppBundle:Movie');/*select*/


        $results = $rc->getMovieByActor($actorName);
        //dump($results);die();

        //$results = $rc->getMovieByTitle('Id corporis incidunt saepe provident.');

        //json_encode ne marche pas sur les objets, il faut donc serialise les résultats par un service déjà présent dans symfonie

        //sans service//
        /*$normalizers = [new ObjectNormalizer() ];
        $encoders = [new JsonEncoder() ];
        $normalizers[0]->setCircularReferenceHandler(function ($object) {
            return $object;
        });


        $serializer = new Serializer($normalizers, $encoders);
        $results = $serializer->serialize($results, 'json');*/
//        dump($results); exit;

        //avec service
        $serializer= $this->get('app.serializer');
        $results = $serializer->serialize($results, 'json');
        //dump($results);die();

        /*$resultXml = $serializer->serialize($results, 'xml');
        return new Response($resultXml);*/

        return new JsonResponse(
             json_decode($results)
        );

    }

}
