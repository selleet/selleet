<?php

namespace Selleet\Infrastructure\BuildingBlocks\Bus\Validation;

use Selleet\Domain\BuildingBlocks\Command\Command;

interface CommandValidator
{
    /**
     * @param Command $command
     *
     * @return array Errors
     */
    public function validate($command): ValidationResult;
}
