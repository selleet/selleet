<?php

namespace Selleet\Container\Infrastructure\BuildingBlocks\EventStore;

use Psr\Container\ContainerInterface;
use Selleet\Infrastructure\BuildingBlocks\EventStore\EventStore;
use Selleet\Infrastructure\BuildingBlocks\EventStore\InFileEventStore;

class InFileEventStoreFactory
{
    public function __invoke(ContainerInterface $container): EventStore
    {
        return new InFileEventStore($container->get('config')['eventstore']['directory']);
    }
}
