<?php

/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 28/12/16
 * Time: 16:46
 */

//on créer des evenements personnalisés


namespace AppBundle\Event;
class OrderEvents
{
    const ORDER_FINALISATION = 'app.event.order.finalisation';//Nom de l'évènement qu'on créé de toute pièce
}