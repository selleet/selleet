<?php

namespace Selleet\Domain\BuildingBlocks\Command\Validation;

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
