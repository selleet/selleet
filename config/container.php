<?php

use Selleet\BuildingBlocks\Command\Bus\CommandBus;
use Selleet\BuildingBlocks\EventStore\EventDispatcher;
use Selleet\BuildingBlocks\EventStore\EventStore;
use Selleet\Container\Config\ConfigFactory;
use Selleet\Purchasing\App\Cart\AddJewelToCartHandler;
use Selleet\Purchasing\Container\App\Bus\CommandBusFactory;
use Selleet\Purchasing\Container\App\Cart\AddJewelToCartHandlerFactory;
use Selleet\Purchasing\Container\Infrastructure\Cart\CartMysqlProjectorFactory;
use Selleet\Purchasing\Container\Infrastructure\Cart\EventStoreCartRepositoryFactory;
use Selleet\Purchasing\Container\Infrastructure\EventStore\EventBusFactory;
use Selleet\Purchasing\Container\Infrastructure\EventStore\InFileEventStoreFactory;
use Selleet\Purchasing\Container\Infrastructure\Jewel\EventStoreJewelRepositoryFactory;
use Selleet\Purchasing\Container\Infrastructure\Jewel\JewelMysqlProjectorFactory;
use Selleet\Purchasing\Container\Infrastructure\PDOFactory;
use Selleet\Purchasing\Domain\Cart\CartRepository;
use Selleet\Purchasing\Domain\Jewel\JewelRepository;
use Selleet\Purchasing\Infrastructure\Cart\CartMysqlProjector;
use Selleet\Purchasing\Infrastructure\Jewel\JewelMysqlProjector;

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
        PDO::class => PDOFactory::class,
        EventDispatcher::class => EventBusFactory::class,
        EventStore::class => InFileEventStoreFactory::class,
        CartMysqlProjector::class => CartMysqlProjectorFactory::class,
        JewelMysqlProjector::class => JewelMysqlProjectorFactory::class,
    ],
];
