<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository;

use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Clock\ClockInterface;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\Session;

/** @template-extends ServiceEntityRepository<Session> */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly ClockInterface $clock,
    ) {
        parent::__construct($registry, Session::class);
    }

    public function findOneBySessionId(string $sessionId): Session|null
    {
        return $this->findOneBy(['sessionId' => $sessionId]);
    }

    public function purge(int $maxLifeTime): void
    {
        $lifetime = Carbon::parse($this->clock->now())->subUTCSeconds($maxLifeTime);

        $this->getEntityManager()
            ->createQuery(
                <<<'DQL'
                    DELETE FROM Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\Session s
                    WHERE s.updatedAt <= :updatedAt
                DQL,
            )
            ->setParameter('updatedAt', $lifetime, Types::DATETIME_MUTABLE)
            ->execute();
    }

    public function destroy(string $sessionId): void
    {
        $this->getEntityManager()
            ->createQuery(
                <<<'DQL'
                    DELETE FROM Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\Session s
                    WHERE s.sessionId = :sessionId
                DQL,
            )
            ->setParameter('sessionId', $sessionId, Types::STRING)
            ->execute();
    }
}
