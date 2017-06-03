<?php

namespace Selleet\BuildingBlocks\Command\Validation;

use Selleet\BuildingBlocks\Command\Command;

interface CommandValidator
{
    /**
     * @param Command $command
     *
     * @return array Errors
     */
    public function validate($command): ValidationResult;
}
