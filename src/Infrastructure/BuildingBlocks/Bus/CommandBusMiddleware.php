<?php

namespace Selleet\Infrastructure\BuildingBlocks\Bus;

use Selleet\Domain\BuildingBlocks\Command\Command;

interface CommandBusMiddleware
{
    public function handle(Command $command): void;
}
