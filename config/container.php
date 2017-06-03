<?php

use Selleet\BuildingBlocks\Command\Bus\CommandBus;
use Selleet\BuildingBlocks\EventStore\EventStore;
use Selleet\Container\Config\ConfigFactory;
use Selleet\Container\Purchasing\App\Bus\CommandBusFactory;
use Selleet\Container\Purchasing\App\Cart\AddJewelToCartHandlerFactory;
use Selleet\Container\Purchasing\Infrastructure\Cart\EventStoreCartRepositoryFactory;
use Selleet\Container\Purchasing\Infrastructure\EventStore\InFileEventStoreFactory;
use Selleet\Container\Purchasing\Infrastructure\Jewel\EventStoreJewelRepositoryFactory;
use Selleet\Purchasing\App\Cart\AddJewelToCartHandler;
use Selleet\Purchasing\Domain\Cart\CartRepository;
use Selleet\Purchasing\Domain\Jewel\JewelRepository;

return [
    'factories' => [
        // Config
        'config' => ConfigFactory::class,

        // App
        CommandBus::class => CommandBusFactory::class,

        // Domain
        CartRepository::class => EventStoreCartRepositoryFactory::class,
        JewelRepository::class => EventStoreJewelRepositoryFactory::class,
        AddJewelToCartHandler::class => AddJewelToCartHandlerFactory::class,

        // Infrastructure
        EventStore::class => InFileEventStoreFactory::class,
    ],
];
