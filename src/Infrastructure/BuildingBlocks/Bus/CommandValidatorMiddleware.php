<?php

namespace Selleet\Infrastructure\BuildingBlocks\Bus;

use Selleet\Domain\BuildingBlocks\Command\Command;

final class CommandValidatorMiddleware implements CommandBusMiddleware
{
    private $validators;

    /**
     * @param array $validators [Command => CommandValidator]
     */
    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    public function handle(Command $command): void
    {
        if (!isset($this->validators[get_class($command)])) {
            return; // @todo log command not registered for validation
        }

        $commandValidator = $this->validators[get_class($command)];

        if (!$commandValidator instanceof CommandValidator) {
            throw new \RuntimeException(get_class($command).' has an invalid command validator.');
        }

        $errors = $commandValidator->validate($command);

        if (!empty($errors)) {
            throw InvalidCommand::withErrors(get_class($command), $errors);
        }
    }
}
