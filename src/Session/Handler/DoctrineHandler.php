<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Session\Handler;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use SessionHandlerInterface;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\Session;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository\SessionRepository;

use function assert;

class DoctrineHandler implements SessionHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function close(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function destroy($sessionId): bool
    {
        $this->getRepository()->destroy($sessionId);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function gc($maxLifeTime)
    {
        $this->getRepository()->purge($maxLifeTime);

        return 1;
    }

    /**
     * @inheritDoc
     */
    public function open($savePath, $sessionId): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function read($sessionId): string
    {
        return $this->getSession($sessionId)->getSessionData() ?? '';
    }

    /**
     * @inheritDoc
     */
    public function write($sessionId, $sessionData): bool
    {
        $session = $this->getSession($sessionId);

        $session->setSessionData($sessionData);
        $session->setUpdatedAt(Carbon::now());

        $this->entityManager->persist($session);
        $this->entityManager->flush($session);

        return true;
    }

    private function getRepository(): SessionRepository
    {
        $repo = $this->entityManager->getRepository(Session::class);
        assert($repo instanceof SessionRepository);

        return $repo;
    }

    private function getSession(string $sessionId): Session
    {
        $session = $this->getRepository()->findOneBySessionId($sessionId);

        if ($session === null) {
            $session = new Session($sessionId);
        }

        return $session;
    }
}
