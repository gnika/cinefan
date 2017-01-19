<?php

namespace AppBundle\Service\Listener;

use AppBundle\Entity\Movie;
use AppBundle\Service\SlugService;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class MovieListener
{
     private $slugService;
     private $fold;

    public function __construct(SlugService $slugService, $fold ){/*on fait un construct quand il appelle un parametre qui est passé au constructeur*/
        $this->slugService = $slugService;
        $this->fold = $fold;
    }

    /*evenement prepersist : evenement qui se déclenche à l'insert uniquement*/
    public function prePersist(Movie $movie, LifecycleEventArgs $eventArgs){

        $slug           =$this->_generateSlug($movie->getTitle());
        $movie->setAlias($slug);
    }

    /*evenement prepersist : evenement qui se déclenche à l'update*/
    public function preUpdate(Movie $movie, PreUpdateEventArgs $eventArgs){


        $entity = $eventArgs->getObject();
        //dump($entity);
        $slug           =$this->_generateSlug($movie->getTitle());
        $movie->setAlias($slug);

        //verifie si le film existe pour remettre la photo lors de l'update
        $poster = $movie->getPoster();
        if(!$poster){
            $movie->setPoster($movie->oldPoster);
        }

    }

    public function preRemove(Movie $movie, LifecycleEventArgs $eventArgs){
        if($movie->getPoster()!='')
            unlink($this->fold.'movie/'.$movie->getPoster());
    }

    private function _generateSlug($slug){
       $changed           = $this->slugService->generateSlug($slug);

        return $changed;
    }


}