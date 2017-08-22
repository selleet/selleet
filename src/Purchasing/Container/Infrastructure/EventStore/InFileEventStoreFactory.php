<?php

namespace Selleet\Purchasing\Container\Infrastructure\EventStore;

use Psr\Container\ContainerInterface;
use Selleet\BuildingBlocks\EventStore\EventDispatcher;
use Selleet\BuildingBlocks\EventStore\EventStore;
use Selleet\BuildingBlocks\EventStore\InFileEventStore;

class InFileEventStoreFactory
{
    public function __invoke(ContainerInterface $container): EventStore
    {
        return new InFileEventStore(
            $container->get(EventDispatcher::class),
            $container->get('config')['eventstore']['directory']
        );
    }
}
