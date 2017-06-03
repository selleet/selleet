<?php

namespace Selleet\BuildingBlocks\Command\Bus;

use Selleet\BuildingBlocks\Command\Command;

class CommandBus
{
    private $middlewares;

    /**
     * @param CommandBusMiddleware[] $middlewares
     */
    public function __construct(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function dispatch(Command $command): void
    {
        foreach ($this->middlewares as $middleware) {
            $this->handleMiddleware($command, $middleware);
        }
    }

    private function handleMiddleware(Command $command, CommandBusMiddleware $middleware): void
    {
        $middleware->handle($command);
    }
}
