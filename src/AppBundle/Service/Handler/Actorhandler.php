<?php

namespace AppBundle\Service\Handler;



use AppBundle\Service\Utils\UploadUtils;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\FormInterface;

class Actorhandler extends Formhandler
{

    protected $form;
    protected $uploadService;

    public function __construct(Registry $doctrine, UploadUtils $uploadService)
    {
        parent::__construct($doctrine);
        $this->uploadService = $uploadService;
    }

    public function process(){

        //appel du service uploadutils
        if($this->form->getData()->getPortrait()!='') {
            $newName = $this->uploadService->uploadFunction($this->form->getData()->getPortrait(), 'actor/');

            $this->form->getData()->setPortrait($newName);
        }

        parent::process();//fais le process de Formhandler et ensuite s'occupe de l'image
    }

    public function delete($id, $entite){

        parent::delete();//


    }


}