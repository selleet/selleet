<?php

namespace Selleet\Container\Purchasing\Infrastructure\Jewel;

use Psr\Container\ContainerInterface;
use Selleet\BuildingBlocks\EventStore\EventStore;
use Selleet\Purchasing\Domain\Jewel\JewelRepository;
use Selleet\Purchasing\Infrastructure\Jewel\EventStoreJewelRepository;

class EventStoreJewelRepositoryFactory
{
    public function __invoke(ContainerInterface $container): JewelRepository
    {
        return new EventStoreJewelRepository($container->get(EventStore::class));
    }
}
