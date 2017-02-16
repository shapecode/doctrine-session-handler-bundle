<?php

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Command;

use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ClearSessionCommand
 *
 * @package Shapecode\Bundle\Doctrine\SessionHandlerBundle\Command
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class ClearSessionCommand extends ContainerAwareCommand
{

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('shapecode:doctrine-session:clear');
        $this->setDescription('Clears all dead session in the database.');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getRepository()->purge();

        $output->writeln('sessions cleared.');
    }

    /**
     * @return \Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository\SessionRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository(SessionInterface::class);
    }

}
