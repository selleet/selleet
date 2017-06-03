<?php

namespace Selleet\BuildingBlocks\Command\Bus;

use Selleet\BuildingBlocks\Command\Command;

interface CommandBusMiddleware
{
    public function handle(Command $command): void;
}
