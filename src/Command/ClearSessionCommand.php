<?php

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ClearSessionCommand
 *
 * @package Shapecode\Bundle\Doctrine\SessionHandlerBundle\Command
 * @author  Nikita Loges
 */
class ClearSessionCommand extends ContainerAwareCommand
{

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('shapecode:doctrine-session:clear');
        $this->setDescription('Clears all dead session in the database.');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $qb = $this->getRepository()->createQueryBuilder('r');
        $qb->delete();
        $qb->where($qb->expr()->lt('r.endOfLife', ':endOfLife'));
        $qb->setParameter('endOfLife', new \DateTime());

        $qb->getQuery()->execute();

        $output->writeln('sessions cleared.');
    }

    /**
     * @return \Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository\SessionRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('ShapecodeDoctrineSessionHandlerBundle:Session');
    }

}
