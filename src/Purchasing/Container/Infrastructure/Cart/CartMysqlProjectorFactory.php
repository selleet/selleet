<?php

namespace Selleet\Purchasing\Container\Infrastructure\Cart;

use Psr\Container\ContainerInterface;
use Selleet\Purchasing\Infrastructure\Cart\CartMysqlProjector;

class CartMysqlProjectorFactory
{
    public function __invoke(ContainerInterface $container): CartMysqlProjector
    {
        return new CartMysqlProjector($container->get(\PDO::class));
    }
}
