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

class DiscountMovieCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:movie:discount')
            ->setDescription('solde des films selon le taux de réduction donné')
            ->addArgument('discount', InputArgument::REQUIRED, 'taux de réduction');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $discount = $input->getArgument('discount');

        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $rc = $doctrine->getRepository('AppBundle:Movie');
        $return = $rc->discountMovieCommande($discount);



        return $output->writeln('Vous avez baissé les prix de '.$discount.'%');

    }


}