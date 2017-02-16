<?php

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SessionRepository
 *
 * @package Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository
 * @author  Nikita Loges
 */
class SessionRepository extends EntityRepository implements SessionRepositoryInterface
{

    /**
     * @return mixed
     */
    public function purge()
    {
        $qb = $this->createQueryBuilder('r');
        $qb->delete();
        $qb->where($qb->expr()->lt('r.endOfLife', ':endOfLife'));
        $qb->setParameter('endOfLife', new \DateTime());

        return $qb->getQuery()->execute();
    }

    /**
     * @param $sessionId
     *
     * @return mixed
     */
    public function destroy($sessionId)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->delete();
        $qb->where($qb->expr()->eq('r.sessionId', ':session_id'));
        $qb->setParameter('session_id', $sessionId);

        return $qb->getQuery()->execute();
    }
}
