<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Session\Handler;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use SessionHandlerInterface;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\Session;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository\SessionRepository;

final readonly class DoctrineHandler implements SessionHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SessionRepository $sessionRepository,
    ) {
    }

    public function close(): bool
    {
        return true;
    }

    /** @inheritDoc */
    public function destroy($id): bool
    {
        $this->sessionRepository->destroy($id);

        return true;
    }

    /**
     * @inheritDoc
     * phpcs:disable Squiz.NamingConventions.ValidVariableName.NotCamelCaps
     */
    public function gc($max_lifetime): int
    {
        $this->sessionRepository->purge($max_lifetime);

        return 1;
    }

    /** @inheritDoc */
    public function open($path, $name): bool
    {
        return true;
    }

    /** @inheritDoc */
    public function read($id): string
    {
        return $this->getSession($id)->getSessionData() ?? '';
    }

    /** @inheritDoc */
    public function write($id, $data): bool
    {
        $session = $this->getSession($id);

        $session->setSessionData($data);
        $session->setUpdatedAt(Carbon::now());

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return true;
    }

    private function getSession(string $id): Session
    {
        $session = $this->sessionRepository->findOneBySessionId($id);

        if ($session === null) {
            $now = Carbon::now();

            $session = new Session(
                $id,
                $now,
                $now,
            );
        }

        return $session;
    }
}
