<?php

namespace Selleet\Container\Infrastructure\Jewelry\Purchasing\Cart;

use Psr\Container\ContainerInterface;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartRepository;
use Selleet\Infrastructure\Jewelry\Purchasing\Cart\InMemoryCartRepository;

class InMemoryCartRepositoryFactory
{
    public function __invoke(ContainerInterface $container): CartRepository
    {
        return new InMemoryCartRepository();
    }
}
