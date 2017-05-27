<?php

namespace Selleet\Container\Infrastructure\BuildingBlocks\Bus;

use Psr\Container\ContainerInterface;
use Selleet\Domain\Jewelry\Purchasing\Cart\AddJewelToCart;
use Selleet\Domain\Jewelry\Purchasing\Cart\AddJewelToCartHandler;
use Selleet\Infrastructure\BuildingBlocks\Bus\CommandBus;

class CommandBusFactory
{
    public function __invoke(ContainerInterface $container): CommandBus
    {
        return new CommandBus(
            [
                AddJewelToCart::class => AddJewelToCartHandler::class,
            ],
            $container
        );
    }
}
