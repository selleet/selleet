<?php

namespace SelleetTest\Infrastructure\BuildingBlocks\Bus\Validation;

use PHPUnit\Framework\TestCase;
use Selleet\Infrastructure\BuildingBlocks\Bus\Validation\CommandValidator;
use Selleet\Infrastructure\BuildingBlocks\Bus\Validation\CommandValidatorMiddleware;
use Selleet\Infrastructure\BuildingBlocks\Bus\Validation\InvalidCommand;
use Selleet\Infrastructure\BuildingBlocks\Bus\Validation\ValidationResult;
use SelleetTest\Infrastructure\BuildingBlocks\Bus\TestCommand;
use SelleetTest\Infrastructure\BuildingBlocks\Bus\TestCommandValidator;

/**
 * @covers \Selleet\Infrastructure\BuildingBlocks\Bus\Validation\CommandValidatorMiddleware
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
