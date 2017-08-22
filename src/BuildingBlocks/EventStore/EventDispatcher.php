<?php

namespace Selleet\BuildingBlocks\EventStore;

use Selleet\BuildingBlocks\Aggregate\DomainEvent;

interface EventDispatcher
{
    public function dispatch(DomainEvent $event): void;

    public function attachListener(string $event, callable $listener): void;
}
