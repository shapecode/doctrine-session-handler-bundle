<?php

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Session\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\Session;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\SessionInterface;

/**
 * Class DoctrineHandler
 *
 * @package Shapecode\Bundle\Doctrine\SessionHandlerBundle\Session\Handler
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class DoctrineHandler implements \SessionHandlerInterface
{

    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        $this->entityManager->flush();

        return true;
    }

    /**
     * @inheritDoc
     */
    public function destroy($session_id)
    {
        return $this->getRepository()->destroy($session_id);
    }

    /**
     * @inheritDoc
     */
    public function gc($maxlifetime)
    {
        $this->getRepository()->purge();

        return true;
    }

    /**
     * @inheritDoc
     */
    public function open($save_path, $session_id)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function read($session_id)
    {
        $session = $this->getSession($session_id);

        if (!$session || is_null($session->getSessionData())) {
            return '';
        }

        $resource = $session->getSessionData();

        return is_resource($resource) ? stream_get_contents($resource) : $resource;
    }

    /**
     * @inheritDoc
     */
    public function write($session_id, $session_data)
    {
        $maxlifetime = (int)ini_get('session.gc_maxlifetime');

        $now = new \DateTime();
        $enfOfLife = new \DateTime();
        $enfOfLife->add(new \DateInterval('PT' . $maxlifetime . 'S'));

        $session = $this->getSession($session_id);

        $session->setSessionData($session_data);
        $session->setUpdatedAt($now);
        $session->setEndOfLife($enfOfLife);

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @return \Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository\SessionRepository
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository(SessionInterface::class);
    }

    /**
     * @param $session_id
     *
     * @return Session
     */
    protected function newSession($session_id)
    {
        $className = $this->getRepository()->getClassName();

        /** @var Session $session */
        $session = new $className;
        $session->setSessionId($session_id);

        return $session;
    }

    /**
     * @param $session_id
     *
     * @return Session
     */
    protected function getSession($session_id)
    {
        $session = $this->getRepository()->findOneBy([
            'sessionId' => $session_id
        ]);

        if (!$session) {
            $session = $this->newSession($session_id);
        }

        return $session;
    }

}
