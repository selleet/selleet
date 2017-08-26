<?php

namespace Selleet\Container\Config;

use Psr\Container\ContainerInterface;

class ConfigFactory
{
    public function __invoke(ContainerInterface $container): array
    {
        if (($env = getenv('SELLEET_ENV_MODE')) === false) {
            throw new \InvalidArgumentException('You must set SELLEET_ENV_MODE env var.');
        }

        if (!file_exists($configFile = __DIR__."/../../../config/config.$env.php")) {
            throw new \RuntimeException("Please create config file $configFile for $env env.");
        }

        return require $configFile;
    }
}
