<?php

namespace AppBundle\Service\Panier;



use AppBundle\Service\Utils\UploadUtils;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Nelmio\Alice\Persister\Doctrine;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class PanierService
{
    private $session;
    public function __construct(Session $session, Registry $doctrine)
    {
        $this->session = $session;
        $this->doctrine = $doctrine;
    }

    public function addPanier($id, $quantity){


        if(!$this->session->has('panier')){
            $this->session->set('panier', [$id => 1]);

        }else{
            $count = $this->session->get('panier');

            if (array_key_exists($id, $count)) {
                if($quantity>0)
                    $count[$id] += 1;
                else
                    $count[$id] -= 1;
            }else
                $count[$id] = 1;
            if($count[$id] < 1)
                unset($count[$id]);
            $this->session->set('panier', $count);
        }

        if(isset($count[$id]))
            return $count[$id];
        else
            return 0;

    }

    public function pricesPanier($arrayProduct){
        $count = $this->session->get('panier');
        $totalPrice = array();
        foreach($arrayProduct as $product){
            $id = $product->getId();
            $price = $product->getPrice();
            $quantity = $count[$id];

            $totalPrice[$id] = $quantity * $price;

        }
        return $totalPrice;
    }

    public function totalPanierPrice(){
        $count = $this->session->get('panier');
        if(count($count)<1) return 0;
        $totalPrice=0;
        $rc = $this->doctrine->getRepository('AppBundle:Movie');
        foreach($count as $key=>$val) {
            $movie = $rc->find($key);
            $totalPrice+=$val*$movie->getPrice();
        }
        return $totalPrice;
    }


}