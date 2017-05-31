<?php

namespace Selleet\Infrastructure\BuildingBlocks\Bus;

use InvalidArgumentException;

final class InvalidCommand extends InvalidArgumentException
{
    public $errors;

    public static function withErrors(string $command, array $errors): self
    {
        $self = new self(sprintf(
            'Tried to submit the command %s but it was invalid.',
            $command
        ));

        $self->errors = $errors;

        return $self;
    }
}
