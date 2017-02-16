<?php

namespace Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Interface SessionRepositoryInterface
 *
 * @package Shapecode\Bundle\Doctrine\SessionHandlerBundle\Repository
 * @author  Nikita Loges
 * @company tenolo GbR
 */
interface SessionRepositoryInterface extends ObjectRepository
{

    /**
     * @return mixed
     */
    public function purge();

    /**
     * @param $sessionId
     *
     * @return mixed
     */
    public function destroy($sessionId);
}
