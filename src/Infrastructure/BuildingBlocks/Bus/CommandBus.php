<?php

namespace Selleet\Infrastructure\BuildingBlocks\Bus;

use Psr\Container\ContainerInterface;
use Selleet\Domain\BuildingBlocks\Command\Command;
use Selleet\Domain\BuildingBlocks\Command\CommandHandler;

class CommandBus
{
    private $handlers;
    private $container;

    /**
     * @param array $handlers [CommandFQCN => CommandHandlerId]
     */
    public function __construct(array $handlers, ContainerInterface $container)
    {
        $this->handlers = $handlers;
        $this->container = $container;
    }

    public function dispatch(Command $command)
    {
        if (!isset($this->handlers[get_class($command)])) {
            throw new \RuntimeException('Command '.get_class($command).' not registered.');
        }

        $commandHandlerId = $this->handlers[get_class($command)];

        if (!$this->container->has($commandHandlerId)) {
            throw new \RuntimeException($commandHandlerId.' is not a registered container service.');
        }

        $commandHandler = $this->container->get($commandHandlerId);

        if (!$commandHandler instanceof CommandHandler) {
            throw new \RuntimeException(get_class($command).' has an invalid command handler.');
        }

        return ($commandHandler)($command);
    }
}
