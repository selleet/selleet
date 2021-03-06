<?php

namespace Selleet\Purchasing\Container\App\Bus;

use Psr\Container\ContainerInterface;
use Selleet\BuildingBlocks\Command\Bus\CommandBus;
use Selleet\BuildingBlocks\Command\Bus\CommandSyncDispatcherMiddleware;
use Selleet\BuildingBlocks\Command\Bus\CommandValidatorMiddleware;
use Selleet\Purchasing\App\Cart\AddJewelToCart;
use Selleet\Purchasing\App\Cart\AddJewelToCartHandler;
use Selleet\Purchasing\App\Cart\AddJewelToCartValidator;

class CommandBusFactory
{
    public function __invoke(ContainerInterface $container): CommandBus
    {
        return new CommandBus([
            new CommandValidatorMiddleware(
                [
                    AddJewelToCart::class => new AddJewelToCartValidator(),
                ]
            ),
            new CommandSyncDispatcherMiddleware(
                [
                    AddJewelToCart::class => AddJewelToCartHandler::class,
                ],
                $container
            ),
        ]);
    }
}
