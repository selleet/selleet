<?php

namespace Selleet\Container\Infrastructure\BuildingBlocks\Bus;

use Psr\Container\ContainerInterface;
use Selleet\Domain\Jewelry\Purchasing\Cart\AddJewelToCart;
use Selleet\Domain\Jewelry\Purchasing\Cart\AddJewelToCartHandler;
use Selleet\Domain\Jewelry\Purchasing\Cart\AddJewelToCartValidator;
use Selleet\Infrastructure\BuildingBlocks\Bus\CommandBus;
use Selleet\Infrastructure\BuildingBlocks\Bus\CommandSyncDispatcherMiddleware;
use Selleet\Infrastructure\BuildingBlocks\Bus\CommandValidatorMiddleware;

class CommandBusFactory
{
    public function __invoke(ContainerInterface $container): CommandBus
    {
        return new CommandBus([
            new CommandSyncDispatcherMiddleware(
                [
                    AddJewelToCart::class => AddJewelToCartHandler::class,
                ],
                $container
            ),
            new CommandValidatorMiddleware(
                [
                    AddJewelToCart::class => new AddJewelToCartValidator(),
                ]
            ),
        ]);
    }
}
