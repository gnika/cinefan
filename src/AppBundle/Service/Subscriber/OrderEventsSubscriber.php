<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 29/12/16
 * Time: 09:15
 */

namespace AppBundle\Service\Subscriber;


use AppBundle\Entity\Movie;
use AppBundle\Event\OrderEvents;
use AppBundle\Event\OrderFinalisationEvent;
use AppBundle\Repository\RoleRepository;
use AppBundle\Service\Panier\PanierService;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class OrderEventsSubscriber implements EventSubscriberInterface
{
    private $doctrine;
    private $pdf;
    private $twig;
    private $servPanier;

    public function __construct(Registry $doctrine, LoggableGenerator $pdf, \Twig_Environment $twig, PanierService $servPanier)
    {
        $this->doctrine = $doctrine;
        $this->pdf = $pdf;
        $this->twig = $twig;
        $this->servPanier = $servPanier;

    }

    public static function getSubscribedEvents()
    {
        // doit retourner un tableau d'evenement : il récupère l'évènement qu'on a créé de toute pièce
        return[
            OrderEvents::ORDER_FINALISATION => 'OrderFinalisation'
        ];
    }

    public function OrderFinalisation(OrderFinalisationEvent $event){
        dump('joachim evenement appelé à l\'appel de la commande');
        //normalement, ici, on génère un pdf de la commande, faut parser le session panier pour get les noms, prix images des products pour l'envoyer en PDF

        $rc = $this->doctrine->getRepository(Movie::class);/*select*/

        $movies = $rc->getMoviesByIds(array_keys($event->getCart()));
        $totalPrice = $this->servPanier->pricesPanier($movies);

        $html = $this->twig->render(':panier:pdf.html.twig', [
            'movies' => $movies,
            'totalPricePerProduct' => $totalPrice,
            'totalPrice' => array_sum($totalPrice)
        ]);
        try{
        $this->pdf->generateFromHtml(
            $html,
            'upload/'.$event->getFileName());

        }catch(\Exception $e) {
//            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }

    }
}