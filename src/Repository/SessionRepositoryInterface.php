<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\SessionInterface;

interface SessionRepositoryInterface extends ObjectRepository
{
    public function findOneBySessionId(string $sessionId) : ?SessionInterface;

    /**
     * @return mixed
     */
    public function purge();

    /**
     * @return mixed
     */
    public function destroy(string $sessionId);
}
