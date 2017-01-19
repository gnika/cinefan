<?php

namespace AppBundle\Service\Handler;



use AppBundle\AppBundle;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class Userhandler extends Formhandler
{

    protected $form;
    protected $userPasswordEncoder;
    protected $mailer;

    public function __construct(Registry $doctrine, UserPasswordEncoder $userPasswordEncoder, \Swift_Mailer $mailer)
    {
        parent::__construct($doctrine);
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->mailer = $mailer;
    }

    public function process(){

        //appel du service cryptage de password
        if($this->form->getData()->getPassword()!='') {

            $role = new Role();
            $rc = $this->doctrine->getRepository('AppBundle:Role');/*select*/
            $default = $rc->getDefaultRole();

            //il attends un objet entité "role"
            $this->form->getData()->setRoles($default);

            $newName = $this->userPasswordEncoder->encodePassword($this->form->getData(), $this->form->getData()->getPassword());

            $this->form->getData()->setPassword($newName);
            $this->form->getData()->setLastConnection(new \DateTime());

            $message = \Swift_Message::newInstance()
                ->setSubject('Inscription réussie')
                ->setFrom('joachim_thibout@yahoo.fr')
                ->setTo($this->form->getData()->getEmail())
                ->setBody(
//                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
//                        'Emails/registration.html.twig',
//                        array('name' => $name)
//                    )
                    'Vous avez bien été inscrit'
                    ,'text/html'
                )
            ;
            $this->mailer->send($message);

        }

        parent::process();//fais le process de Formhandler et ensuite s'occupe de l'image
    }

    public function delete($id, $entite){

        parent::delete();//


    }


}