<?php

namespace AppBundle\Service\Subscriber;


use AppBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Validator\Constraints\DateTime;

class AuthentificationSubscriber implements EventSubscriberInterface
{
    private $doctrine;
    private $session;
    private $maxfail;

    public function __construct(Registry $doctrine, Session $session, $maxfail)
    {
        $this->doctrine = $doctrine;
        $this->session = $session;
        $this->maxfail = $maxfail;
    }

    public static function getSubscribedEvents()
    {
        // doit retourner un tableau d'evenement
        return[
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'successFunction',
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'failureFunction',

        ];
    }

    public function successFunction( AuthenticationEvent $event){



        if($event->getAuthenticationToken()->getUser() instanceof User) {// en anonyme est toujours exécuté car il attends la connection. Arrete de s'exécuter quand il est connecté
            $event->getAuthenticationToken()->getUser()->setLastConnection(new \DateTime());//set la  derniere date de connexion
            $em = $this->doctrine->getManager();


            $em->persist($event->getAuthenticationToken()->getUser());


            $em->flush();
        }

    }

        public function failureFunction( AuthenticationFailureEvent $event){

            if(!$this->session->has('authenfailure')){
                $this->session->set('authenfailure', 1);
            }else{
                $count = $this->session->get('authenfailure');
                $count++;
                $this->session->set('authenfailure', $count);
            }

            if($this->session->get('authenfailure')>2){
                dump('trois échec, c\'est trop !');
                die();
            }

    }

}