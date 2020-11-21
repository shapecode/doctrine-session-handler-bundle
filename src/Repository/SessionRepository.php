<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository;

use Carbon\Carbon;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\Session;

/**
 * @method Session|null find($id, ?int $lockMode = null, ?int $lockVersion = null)
 * @method Session[] findAll()
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[] findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = null)
 */
class SessionRepository extends EntityRepository
{
    public function findOneBySessionId(string $sessionId): ?Session
    {
        return $this->findOneBy(['sessionId' => $sessionId]);
    }

    public function purge(int $maxLifeTime): void
    {
        $lifetime = Carbon::now()->subRealSeconds($maxLifeTime);

        $this->_em->createQuery(
            <<<'DQL'
                DELETE FROM Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\Session s
                WHERE s.updatedAt <= :updatedAt
            DQL
        )
            ->setParameter('updatedAt', $lifetime, Types::DATETIME_MUTABLE)
            ->execute();
    }

    public function destroy(string $sessionId): void
    {
        $this->_em->createQuery(
            <<<'DQL'
                DELETE FROM Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\Session s
                WHERE s.sessionId = :sessionId
            DQL
        )
            ->setParameter('sessionId', $sessionId, Types::STRING)
            ->execute();
    }
}
