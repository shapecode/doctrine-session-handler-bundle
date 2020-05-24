<?php

declare(strict_types=1);

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity;

use DateTime;

interface SessionInterface
{
    public function getSessionId() : string;

    public function setSessionId(string $sessionId) : void;

    public function getSessionData() : ?string;

    public function setSessionData(?string $sessionData) : void;

    public function getCreatedAt() : DateTime;

    public function setCreatedAt(DateTime $createdAt) : void;

    public function getUpdatedAt() : DateTime;

    public function setUpdatedAt(DateTime $updatedAt) : void;

    public function getEndOfLife() : DateTime;

    public function setEndOfLife(DateTime $endOfLife) : void;
}
