<?php

namespace Selleet\Purchasing\Container\App\Cart;

use Psr\Container\ContainerInterface;
use Selleet\Purchasing\App\Cart\AddJewelToCartHandler;
use Selleet\Purchasing\Domain\Cart\CartRepository;

final class AddJewelToCartHandlerFactory
{
    public function __invoke(ContainerInterface $container): AddJewelToCartHandler
    {
        return new AddJewelToCartHandler($container->get(CartRepository::class));
    }
}
