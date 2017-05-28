<?php

namespace Selleet\Container\Infrastructure\Jewelry\Purchasing\Jewel;

use Psr\Container\ContainerInterface;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelRepository;
use Selleet\Infrastructure\BuildingBlocks\EventStore\EventStore;
use Selleet\Infrastructure\Jewelry\Purchasing\Jewel\EventStoreJewelRepository;

class EventStoreJewelRepositoryFactory
{
    public function __invoke(ContainerInterface $container): JewelRepository
    {
        return new EventStoreJewelRepository($container->get(EventStore::class));
    }
}
