<?php

namespace Selleet\BuildingBlocks\Command;

use Selleet\BuildingBlocks\DomainEvent;

interface CommandHandler
{
    /**
     * @param Command $command
     *
     * @return DomainEvent[]
     */
    public function __invoke(Command $command): void;
}
