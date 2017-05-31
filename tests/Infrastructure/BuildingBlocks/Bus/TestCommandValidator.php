<?php

namespace SelleetTest\Infrastructure\BuildingBlocks\Bus;

use Selleet\Infrastructure\BuildingBlocks\Bus\CommandValidator;

final class TestCommandValidator implements CommandValidator
{
    private $errors = [];

    /**
     * @param TestCommand $command
     */
    public function validate($command): array
    {
        if ($command->test !== 'foo') {
            $this->errors[] = 'test is invalid';
        }

        return $this->errors;
    }
}
