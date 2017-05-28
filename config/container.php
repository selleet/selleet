<?php

use Selleet\Container\Config\ConfigFactory;
use Selleet\Container\Domain\Jewelry\Purchasing\Cart\AddJewelToCartHandlerFactory;
use Selleet\Container\Infrastructure\BuildingBlocks\Bus\CommandBusFactory;
use Selleet\Container\Infrastructure\BuildingBlocks\EventStore\InFileEventStoreFactory;
use Selleet\Container\Infrastructure\Jewelry\Purchasing\Cart\EventStoreCartRepositoryFactory;
use Selleet\Container\Infrastructure\Jewelry\Purchasing\Jewel\EventStoreJewelRepositoryFactory;
use Selleet\Domain\Jewelry\Purchasing\Cart\AddJewelToCartHandler;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartRepository;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelRepository;
use Selleet\Infrastructure\BuildingBlocks\Bus\CommandBus;
use Selleet\Infrastructure\BuildingBlocks\EventStore\EventStore;

return [
    'factories' => [
        // Config
        'config' => ConfigFactory::class,

        // Domain
        CartRepository::class => EventStoreCartRepositoryFactory::class,
        JewelRepository::class => EventStoreJewelRepositoryFactory::class,
        AddJewelToCartHandler::class => AddJewelToCartHandlerFactory::class,

        // Infrastructure
        CommandBus::class => CommandBusFactory::class,
        EventStore::class => InFileEventStoreFactory::class,
    ],
];
