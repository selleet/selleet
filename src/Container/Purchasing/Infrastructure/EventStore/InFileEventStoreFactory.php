<?php

namespace Selleet\Container\Purchasing\Infrastructure\EventStore;

use Psr\Container\ContainerInterface;
use Selleet\BuildingBlocks\EventStore\EventStore;
use Selleet\BuildingBlocks\EventStore\InFileEventStore;

class InFileEventStoreFactory
{
    public function __invoke(ContainerInterface $container): EventStore
    {
        return new InFileEventStore($container->get('config')['eventstore']['directory']);
    }
}
