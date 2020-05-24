<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Session\Handler;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use SessionHandlerInterface;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\SessionInterface;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository\SessionRepositoryInterface;
use function assert;
use function ini_get;

class DoctrineHandler implements SessionHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function close() : bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function destroy($sessionId) : bool
    {
        $this->getRepository()->destroy($sessionId);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function gc($maxlifetime) : bool
    {
        $this->getRepository()->purge();

        return true;
    }

    /**
     * @inheritDoc
     */
    public function open($savePath, $sessionId) : bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function read($sessionId) : string
    {
        return $this->getSession($sessionId)->getSessionData() ?? '';
    }

    /**
     * @inheritDoc
     */
    public function write($sessionId, $sessionData) : bool
    {
        $maxLifeTime = (int) ini_get('session.gc_maxlifetime');

        $now       = new DateTime();
        $enfOfLife = new DateTime();
        $enfOfLife->add(new DateInterval('PT' . $maxLifeTime . 'S'));

        $session = $this->getSession($sessionId);

        $session->setSessionData($sessionData);
        $session->setUpdatedAt($now);
        $session->setEndOfLife($enfOfLife);

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return true;
    }

    private function getRepository() : SessionRepositoryInterface
    {
        $repo = $this->entityManager->getRepository(SessionInterface::class);
        assert($repo instanceof SessionRepositoryInterface);

        return $repo;
    }

    private function newSession(string $sessionId) : SessionInterface
    {
        $className = $this->getRepository()->getClassName();

        $session = new $className();
        assert($session instanceof SessionInterface);

        $session->setSessionId($sessionId);

        return $session;
    }

    private function getSession(string $sessionId) : SessionInterface
    {
        $session = $this->getRepository()->findOneBySessionId($sessionId);

        if ($session === null) {
            $session = $this->newSession($sessionId);
        }

        return $session;
    }
}
