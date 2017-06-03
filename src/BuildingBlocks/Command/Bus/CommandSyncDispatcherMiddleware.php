<?php

namespace Selleet\BuildingBlocks\Command\Bus;

use Psr\Container\ContainerInterface;
use Selleet\BuildingBlocks\Command\Command;
use Selleet\BuildingBlocks\Command\CommandHandler;

final class CommandSyncDispatcherMiddleware implements CommandBusMiddleware
{
    private $handlers;
    private $serviceLocator;

    /**
     * @param array $handlers [CommandFQCN => CommandHandlerId]
     */
    public function __construct(array $handlers, ContainerInterface $serviceLocator)
    {
        $this->handlers = $handlers;
        $this->serviceLocator = $serviceLocator;
    }

    public function handle(Command $command): void
    {
        if (!isset($this->handlers[get_class($command)])) {
            throw new \RuntimeException('Command '.get_class($command).' not registered.');
        }

        $commandHandlerId = $this->handlers[get_class($command)];

        if (!$this->serviceLocator->has($commandHandlerId)) {
            throw new \RuntimeException($commandHandlerId.' is not a registered container service.');
        }

        $commandHandler = $this->serviceLocator->get($commandHandlerId);

        if (!$commandHandler instanceof CommandHandler) {
            throw new \RuntimeException(get_class($command).' has an invalid command handler.');
        }

        ($commandHandler)($command);
    }
}
