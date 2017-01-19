<?php

namespace AppBundle\Service\Listener;

use AppBundle\Entity\Category;
use AppBundle\Service\SlugService;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class CategoryListener
{
     private $slugService;

    public function __construct(SlugService $slugService ){/*on fait un construct quand il appelle un parametre qui est passé au constructeur*/
        $this->slugService = $slugService;
    }

    /*evenement prepersist : evenement qui se déclenche à l'insert*/
    public function prePersist(Category $category, LifecycleEventArgs $eventArgs){

        $slug           =$this->_generateSlug($category->getName());
        $category->setSlug($slug);
        //dump($category); exit;
    }

    /*evenement prepersist : evenement qui se déclenche à l'insert*/
    public function preUpdate(Category $category, PreUpdateEventArgs $eventArgs){
        $entity = $eventArgs->getObject();
        //dump($entity);
        $slug           =$this->_generateSlug($category->getName());
        $category->setSlug($slug);
    }

    private function _generateSlug($slug){
       $changed           = $this->slugService->generateSlug($slug);

        return $changed;
    }


}