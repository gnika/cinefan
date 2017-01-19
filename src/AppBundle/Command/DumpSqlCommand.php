<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 30/12/16
 * Time: 09:37
 */

namespace AppBundle\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class DumpSqlCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:dump:sql')
            ->setDescription('dump de la base de donnée');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d');
        $process = new Process('mkdir var/dumpsql-'.$date);
        $process->run();

        $process = new Process('mysqldump -uroot -ptroiswa cinefan > var/dumpsql-'.$date.'/dump.sql');
        $process->run();

        return $output->writeln('Vous avez dumpé la base de donnée.');

    }


}