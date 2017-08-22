<?php

namespace Selleet\BuildingBlocks\EventStore;

use Selleet\BuildingBlocks\Aggregate\DomainEvent;

final class EventBus implements EventDispatcher
{
    private $listeners;

    public function __construct()
    {
        $this->listeners = [];
    }

    public function dispatch(DomainEvent $event): void
    {
        $listenersForEvent = $this->listeners[get_class($event)] ?? [];

        foreach ($listenersForEvent as $listener) {
            $listener($event);
        }
    }

    public function attachListener(string $event, callable $listener): void
    {
        $this->listeners[$event][] = $listener;
    }
}
