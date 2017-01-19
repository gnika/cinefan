<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 29/12/16
 * Time: 09:29
 */

namespace AppBundle\Controller;
use AppBundle\Event\OrderEvents;
use AppBundle\Event\OrderFinalisationEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class OrderController extends Controller
{



    /**
    * @Route("/order/finalisation", name="app.order.finalisation")
    */
    public function finalisation(Request $request){

        //service qui déclenche l'event
        $eventDispatcher = $this->get('event_dispatcher');
        $event = new OrderFinalisationEvent();
        $event->setCart($request->getSession()->get('panier'));
        $event->setUserEmail($this->getUser()->getEmail());
        $event->setFileName('file'.time().$this->getUser()->getId().'.pdf');

        $eventDispatcher->dispatch(OrderEvents::ORDER_FINALISATION, $event);//l'évent qu'on a créé

        $this->get('session')->remove('panier');

        return $this->render('order/index.html.twig', [
            'pdf' => $event->getFileName()
        ]);
    }
}