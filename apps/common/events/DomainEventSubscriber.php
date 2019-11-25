<?php

namespace Idy\Common\Events;

interface DomainEventSubscriber
{
    /**
     * @param DomainEvent $aDomainEvent
     */
    public function handle($aDomainEvent);

    /**
     * @param DomainEvent $aDomainEvent
     * @return int
     */
    public function isSubscribedTo($aDomainEvent);
}