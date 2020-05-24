<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use function is_resource;
use function stream_get_contents;

/**
 * @ORM\Entity(repositoryClass="Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository\SessionRepository")
 * @ORM\Table(name="symfony_session")
 */
class Session implements SessionInterface
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     *
     * @var string
     */
    protected $sessionId;

    /**
     * @ORM\Column(type="blob", nullable=true)
     *
     * @var resource|string|null
     */
    protected $sessionData;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    protected $endOfLife;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->setUpdatedAt(new DateTime());
    }

    public function getSessionId() : string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId) : void
    {
        $this->sessionId = $sessionId;
    }

    public function getSessionData() : ?string
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

    public function setSessionData(?string $sessionData) : void
    {
        $this->sessionData = $sessionData;
    }

    public function getCreatedAt() : DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt) : void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt() : DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt) : void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getEndOfLife() : DateTime
    {
        return $this->endOfLife;
    }

    public function setEndOfLife(DateTime $endOfLife) : void
    {
        $this->endOfLife = $endOfLife;
    }
}
