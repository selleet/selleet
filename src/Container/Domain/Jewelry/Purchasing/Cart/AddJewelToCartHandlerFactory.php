<?php

namespace Selleet\Container\Domain\Jewelry\Purchasing\Cart;

use Psr\Container\ContainerInterface;
use Selleet\Domain\Jewelry\Purchasing\Cart\AddJewelToCartHandler;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartRepository;

final class AddJewelToCartHandlerFactory
{
    public function __invoke(ContainerInterface $container): AddJewelToCartHandler
    {
        return new AddJewelToCartHandler($container->get(CartRepository::class));
    }
}
