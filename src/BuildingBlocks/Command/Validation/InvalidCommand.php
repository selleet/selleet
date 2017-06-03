<?php

namespace Selleet\BuildingBlocks\Command\Validation;

use InvalidArgumentException;

final class InvalidCommand extends InvalidArgumentException
{
    private $errors;

    public static function withErrors(string $command, array $errors): self
    {
        $self = new self(sprintf(
            'Tried to submit the command %s but it was invalid.',
            $command
        ));

        $self->errors = $errors;

        return $self;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
