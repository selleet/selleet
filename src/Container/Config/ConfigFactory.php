<?php

namespace Selleet\Container\Config;

use Psr\Container\ContainerInterface;

class ConfigFactory
{
    public function __invoke(ContainerInterface $container): array
    {
        $config = require __DIR__.'/../../../config/config.php';

        return $config;
    }
}
