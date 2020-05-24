<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\SessionInterface;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository\SessionRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function assert;

class ClearSessionCommand extends Command
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure() : void
    {
        $this->setName('shapecode:doctrine-session:clear');
        $this->setDescription('Clears all dead session in the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $repo = $this->entityManager->getRepository(SessionInterface::class);
        assert($repo instanceof SessionRepositoryInterface);

        $repo->purge();

        $output->writeln('sessions cleared.');

        return 0;
    }
}
