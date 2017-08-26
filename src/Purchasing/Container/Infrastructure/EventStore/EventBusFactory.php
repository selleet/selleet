<?php

namespace Selleet\Purchasing\Container\Infrastructure\EventStore;

use Psr\Container\ContainerInterface;
use Selleet\BuildingBlocks\EventStore\EventBus;

class EventBusFactory
{
    public function __invoke(ContainerInterface $container): EventBus
    {
        $eventBus = new EventBus();
        $projectors = $container->get('config')['eventstore']['projectors'];

        foreach ($projectors as $projectorFQCN) {
            $projector = $container->get($projectorFQCN);

            $eventsWithHandler = $projector();

            foreach ($eventsWithHandler as $event => $handler) {
                $eventBus->attachListener($event, $handler);
            }
        }

        return $eventBus;
    }
}
