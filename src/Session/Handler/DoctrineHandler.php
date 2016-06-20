<?php

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Session\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\Session;

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
        $qb = $this->getRepository()->createQueryBuilder('r');
        $qb->delete();
        $qb->where($qb->expr()->eq('r.sessionId', ':session_id'));
        $qb->setParameter('session_id', $session_id);

        return $qb->getQuery()->execute();
    }

    /**
     * @inheritDoc
     */
    public function gc($maxlifetime)
    {
        $qb = $this->getRepository()->createQueryBuilder('r');
        $qb->delete();
        $qb->where($qb->expr()->lt('r.endOfLife', ':endOfLife'));
        $qb->setParameter('endOfLife', new \DateTime());

        $qb->getQuery()->execute();

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
        $session = $this->getRepository()->findOneBy([
            'sessionId' => $session_id
        ]);

        if (!$session) {
            return '';
        }

        $resource = $session->getData();

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
        $enfOfLife->add(new \DateInterval('PT'.$maxlifetime.'S'));

        $session = $this->getRepository()->findOneBy([
            'sessionId' => $session_id
        ]);

        if (!$session) {
            $session = $this->getNewSession();
            $session->setSessionId($session_id);
        }

        $session->setData($session_data);
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
        return $this->entityManager->getRepository('ShapecodeDoctrineSessionHandlerBundle:Session');
    }

    /**
     * @return Session
     */
    protected function getNewSession()
    {
        $className = $this->getRepository()->getClassName();

        return new $className;
    }

}