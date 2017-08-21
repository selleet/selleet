<?php

namespace Selleet\Purchasing\Container\Infrastructure\Cart;

use Psr\Container\ContainerInterface;
use Selleet\BuildingBlocks\EventStore\EventStore;
use Selleet\Purchasing\Domain\Cart\CartRepository;
use Selleet\Purchasing\Infrastructure\Cart\EventStoreCartRepository;

class EventStoreCartRepositoryFactory
{
    public function __invoke(ContainerInterface $container): CartRepository
    {
        return new EventStoreCartRepository($container->get(EventStore::class));
    }
}
