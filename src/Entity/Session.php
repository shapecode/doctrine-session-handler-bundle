<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository\SessionRepository;

use function is_resource;
use function is_string;
use function stream_get_contents;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ORM\Table(name: 'symfony_session')]
class Session
{
    #[ORM\Column(type: Types::STRING)]
    #[ORM\Id()]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private string $sessionId;

    /** @var resource|string|null */
    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $sessionData;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $updatedAt;

    public function __construct(
        string $sessionId,
        DateTimeInterface $createdAt,
        DateTimeInterface $updatedAt,
    ) {
        $this->sessionId = $sessionId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getSessionData(): string|null
    {
        $resource = $this->sessionData;

        if (is_resource($resource)) {
            $resource = stream_get_contents($resource);

            if ($resource === false) {
                return null;
            }
        }

        if (is_string($resource)) {
            return $resource;
        }

        return null;
    }

    /** @phpstan-param resource|string|null $sessionData */
    public function setSessionData($sessionData): void
    {
        $this->sessionData = $sessionData;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
