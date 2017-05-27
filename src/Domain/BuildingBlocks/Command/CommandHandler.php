<?php

namespace Selleet\Domain\BuildingBlocks\Command;

use Selleet\Domain\BuildingBlocks\DomainEvent;

interface CommandHandler
{
    /**
     * @param Command $command
     *
     * @return DomainEvent[]
     */
    public function __invoke(Command $command): array;
}
