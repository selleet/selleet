<?php

namespace Selleet\Container\Infrastructure\Jewelry\Purchasing\Cart;

use Psr\Container\ContainerInterface;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartRepository;
use Selleet\Infrastructure\BuildingBlocks\EventStore\EventStore;
use Selleet\Infrastructure\Jewelry\Purchasing\Cart\EventStoreCartRepository;

class EventStoreCartRepositoryFactory
{
    public function __invoke(ContainerInterface $container): CartRepository
    {
        return new EventStoreCartRepository($container->get(EventStore::class));
    }
}
