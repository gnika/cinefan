<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 30/12/16
 * Time: 09:37
 */

namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteMovieCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:movie:delete')
            ->setDescription('Suppression des vieux films en passant une année en paramètre')
            ->addArgument('year', InputArgument::REQUIRED, $this->getDescription())
            ->addOption('earlier', 's', InputOption::VALUE_NONE, 'par défaut supprime tous les films avant la date donnée');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = $input->getArgument('year');
        $earlier = $input->getOption('earlier');

        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $rc = $doctrine->getRepository('AppBundle:Movie');
        $return = $rc->deleteMovieCommande($year, $earlier);



        return $output->writeln('Vous avez envoyé '.$year.' avec l\'option '.($earlier ?  'plus tot' : 'plus tard').' : '.$return.' entrées supprimées');

    }


}