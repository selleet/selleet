<?php

namespace SelleetTest\BuildingBlocks\Command\Bus;

use Selleet\BuildingBlocks\Command\Validation\CommandValidator;
use Selleet\BuildingBlocks\Command\Validation\ValidationResult;

final class TestCommandValidator implements CommandValidator
{
    /**
     * @param TestCommand $command
     */
    public function validate($command): ValidationResult
    {
        $errors = [];

        if ($command->test !== 'foo') {
            $errors['test'] = 'test is invalid';
        }

        return new ValidationResult($errors);
    }
}
