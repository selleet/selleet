<?php

namespace Selleet\BuildingBlocks\Command;

interface CommandHandler
{
    /**
     * @param Command $command
     */
    public function __invoke(Command $command): void;
}
