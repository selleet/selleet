<?php

namespace Selleet\Infrastructure\BuildingBlocks\Bus;

use Selleet\Domain\BuildingBlocks\Command\Command;

interface CommandValidator
{
    /**
     * @param Command $command
     *
     * @return array Errors
     */
    public function validate($command): array;
}
