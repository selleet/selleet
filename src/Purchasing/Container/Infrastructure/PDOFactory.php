<?php

namespace Selleet\Purchasing\Container\Infrastructure;

use Psr\Container\ContainerInterface;

class PDOFactory
{
    public function __invoke(ContainerInterface $container): \PDO
    {
        return new \PDO(
            $container->get('config')['pdo']['dsn'],
            $container->get('config')['pdo']['username'],
            $container->get('config')['pdo']['password']
        );
    }
}
