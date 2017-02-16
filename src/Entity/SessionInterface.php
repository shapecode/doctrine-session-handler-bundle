<?php

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity;

/**
 * Interface SessionInterface
 *
 * @package Shapecode\Bundle\Doctrine\SessionHandlerBundle\Entity
 * @author  Nikita Loges
 */
interface SessionInterface
{

    /**
     * @inheritdoc
     */
    public function getId();

    /**
     * @inheritdoc
     */
    public function setId($id = null);

    /**
     * @return string
     */
    public function getSessionId();

    /**
     * @param string $sessionId
     */
    public function setSessionId($sessionId);

    /**
     * @return mixed
     */
    public function getSessionData();

    /**
     * @param mixed $sessionData
     */
    public function setSessionData($sessionData);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * @return mixed
     */
    public function getUpdatedAt();

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * @return \DateTime
     */
    public function getEndOfLife();

    /**
     * @param \DateTime $endOfLife
     */
    public function setEndOfLife(\DateTime $endOfLife);
}
