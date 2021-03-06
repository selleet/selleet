<?php

namespace SelleetTest\BuildingBlocks\Command\Bus;

use PHPUnit\Framework\TestCase;
use Selleet\BuildingBlocks\Command\Bus\CommandValidatorMiddleware;
use Selleet\BuildingBlocks\Command\Validation\CommandValidator;
use Selleet\BuildingBlocks\Command\Validation\InvalidCommand;
use Selleet\BuildingBlocks\Command\Validation\ValidationResult;

/**
 * @covers \Selleet\BuildingBlocks\Command\Bus\CommandValidatorMiddleware
 */
final class CommandValidatorMiddlewareTest extends TestCase
{
    public function testCanBeCreatedFromValidValidators(): void
    {
        $this->assertInstanceOf(
            CommandValidatorMiddleware::class,
            new CommandValidatorMiddleware(
                [
                    TestCommand::class => new TestCommandValidator(),
                ]
            )
        );
    }

    public function testCanHandleAValidCommand(): void
    {
        $testCommand = new TestCommand();
        $testCommand->test = 'foo';

        $testCommandValidator = $this->prophesize(CommandValidator::class);
        $testCommandValidator->validate($testCommand)->willReturn(new ValidationResult([]));

        $middleware = new CommandValidatorMiddleware(
            [
                TestCommand::class => $testCommandValidator->reveal(),
            ]
        );

        $middleware->handle($testCommand);

        $testCommandValidator->validate($testCommand)->shouldHaveBeenCalled();
    }

    public function testCanHandleAnInvalidCommand(): void
    {
        $this->expectException(InvalidCommand::class);
        $this->expectExceptionMessage(
            sprintf('Tried to submit the command %s but it was invalid.', TestCommand::class)
        );

        $testCommand = new TestCommand();

        $testCommandValidator = $this->prophesize(CommandValidator::class);
        $testCommandValidator->validate($testCommand)->willReturn(new ValidationResult([
            'test' => 'test is invalid',
        ]));

        $testCommandValidator->validate($testCommand)->shouldBeCalled();

        $middleware = new CommandValidatorMiddleware(
            [
                TestCommand::class => $testCommandValidator->reveal(),
            ]
        );

        $middleware->handle($testCommand);
    }

    public function testCannotHandleCommandsWithInvalidValidators(): void
    {
        $this->expectException(\RuntimeException::class);

        $testCommand = new TestCommand();

        $testCommandValidator = $this->prophesize(\stdClass::class);

        $middleware = new CommandValidatorMiddleware(
            [
                TestCommand::class => $testCommandValidator->reveal(),
            ]
        );

        $middleware->handle($testCommand);
    }
}
