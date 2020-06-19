<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository;

use Doctrine\Persistence\ObjectRepository;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity\SessionInterface;

interface SessionRepositoryInterface extends ObjectRepository
{
    public function findOneBySessionId(string $sessionId): ?SessionInterface;

    public function purge(): void;

    public function destroy(string $sessionId): void;
}
