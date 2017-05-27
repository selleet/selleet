<?php

namespace Selleet\Container\Infrastructure\Jewelry\Purchasing\Jewel;

use Psr\Container\ContainerInterface;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelRepository;
use Selleet\Infrastructure\Jewelry\Purchasing\Jewel\InMemoryJewelRepository;

class InMemoryJewelRepositoryFactory
{
    public function __invoke(ContainerInterface $container): JewelRepository
    {
        return new InMemoryJewelRepository();
    }
}
