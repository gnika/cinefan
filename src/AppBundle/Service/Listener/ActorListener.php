<?php

namespace AppBundle\Service\Listener;

use AppBundle\Entity\Actor;
use AppBundle\Service\SlugService;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class ActorListener
{
     private $slugService;
     private $fold;

    public function __construct(SlugService $slugService, $fold ){/*on fait un construct quand il appelle un parametre qui est passé au constructeur*/
        $this->slugService = $slugService;
        $this->fold = $fold;
    }

    /*evenement prepersist : evenement qui se déclenche à l'insert uniquement*/
    public function prePersist(Actor $actor, LifecycleEventArgs $eventArgs){

        $slug           =$this->_generateSlug($actor->getLastname());
        $actor->setAlias($slug);
    }

    /*evenement prepersist : evenement qui se déclenche à l'update*/
    public function preUpdate(Actor $actor, PreUpdateEventArgs $eventArgs){


        $entity = $eventArgs->getObject();
        //dump($entity);
        $slug           =$this->_generateSlug($actor->getLastname());
        $actor->setAlias($slug);

        //verifie si le film existe pour remettre la photo lors de l'update
        $poster = $actor->getPortrait();
        if(!$poster){
            $actor->setPortrait($actor->oldPoster);
        }

    }

    public function preRemove(Actor $actor, LifecycleEventArgs $eventArgs){
        if($actor->getPortrait()!='')
            unlink($this->fold.'actor/'.$actor->getPortrait());
    }

    private function _generateSlug($slug){
       $changed           = $this->slugService->generateSlug($slug);

        return $changed;
    }


}