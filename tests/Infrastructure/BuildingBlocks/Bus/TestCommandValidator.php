<?php

namespace SelleetTest\Infrastructure\BuildingBlocks\Bus;

use Selleet\Infrastructure\BuildingBlocks\Bus\Validation\CommandValidator;
use Selleet\Infrastructure\BuildingBlocks\Bus\Validation\ValidationResult;

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
