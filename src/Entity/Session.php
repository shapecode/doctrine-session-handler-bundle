<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity;

use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

use function is_resource;
use function stream_get_contents;

/**
 * @ORM\Entity(repositoryClass="Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository\SessionRepository")
 * @ORM\Table(name="symfony_session")
 */
class Session
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private string $sessionId;

    /**
     * @ORM\Column(type="blob", nullable=true)
     *
     * @var resource|string|null
     */
    private $sessionData;

    /** @ORM\Column(type="datetime") */
    private DateTimeInterface $createdAt;

    /** @ORM\Column(type="datetime") */
    private DateTimeInterface $updatedAt;

    public function __construct(string $sessionId)
    {
        $this->sessionId = $sessionId;
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getSessionData(): ?string
    {
        if (is_resource($this->sessionData)) {
            $resource = stream_get_contents($this->sessionData);

            if ($resource === false) {
                return null;
            }

            return $resource;
        }

        return $this->sessionData;
    }

    public function setSessionData(?string $sessionData): void
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
