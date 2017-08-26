<?php

namespace Selleet\Purchasing\Container\Infrastructure\Jewel;

use Psr\Container\ContainerInterface;
use Selleet\Purchasing\Infrastructure\Jewel\JewelMysqlProjector;

class JewelMysqlProjectorFactory
{
    public function __invoke(ContainerInterface $container): JewelMysqlProjector
    {
        return new JewelMysqlProjector($container->get(\PDO::class));
    }
}
