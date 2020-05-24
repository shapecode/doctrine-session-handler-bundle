<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\SessionInterface;
use function assert;

class SessionRepository extends EntityRepository implements SessionRepositoryInterface
{
    public function findOneBySessionId(string $sessionId) : ?SessionInterface
    {
        $session = $this->findOneBy(['sessionId' => $sessionId]);
        assert($session instanceof SessionInterface || $session === null);

        return $session;
    }

    /**
     * @return mixed
     */
    public function purge()
    {
        $qb = $this->createQueryBuilder('r');
        $qb->delete();
        $qb->where($qb->expr()->lt('r.endOfLife', ':endOfLife'));
        $qb->setParameter('endOfLife', new DateTime(), Types::DATETIME_MUTABLE);

        return $qb->getQuery()->execute();
    }

    /**
     * @return mixed
     */
    public function destroy(string $sessionId)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->delete();
        $qb->where($qb->expr()->eq('r.sessionId', ':session_id'));
        $qb->setParameter('session_id', $sessionId, Types::STRING);

        return $qb->getQuery()->execute();
    }
}
