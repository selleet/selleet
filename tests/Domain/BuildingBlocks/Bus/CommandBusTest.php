<?php

namespace SelleetTest\Domain\BuildingBlocks\Bus;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Selleet\Domain\BuildingBlocks\Command\Command;
use Selleet\Domain\BuildingBlocks\Command\CommandHandler;
use Selleet\Infrastructure\BuildingBlocks\Bus\CommandBus;

/**
 * @covers \Selleet\Infrastructure\BuildingBlocks\Bus\CommandBus
 */
final class CommandBusTest extends TestCase
{
    public function testCanBeCreatedFromValidHandlers(): void
    {
        $this->assertInstanceOf(
            CommandBus::class,
            new CommandBus(
                [
                    TestCommand::class => 'test_command_handler',
                ],
                $this->prophesize(ContainerInterface::class)->reveal()
            )
        );
    }

    public function testCanDispatchAValidCommand(): void
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->get('test_command_handler')->willReturn(new class() implements CommandHandler {
            /** @param TestCommand $command */
            public function __invoke(Command $command): array
            {
                return [$command->test];
            }
        });
        $container->has('test_command_handler')->willReturn(true);

        $commandBus = new CommandBus(
            [
                TestCommand::class => 'test_command_handler',
            ],
            $container->reveal()
        );

        $command = new TestCommand();
        $command->test = 'foo';

        $events = $commandBus->dispatch($command);

        $this->assertCount(1, $events);
        $this->assertSame('foo', $events[0]);
    }

    public function testCannotDispatchANotRegisteredCommand(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Command '.TestCommand::class.' not registered.');

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('test_command_handler')->willReturn(new class() implements CommandHandler {
            /** @param TestCommand $command */
            public function __invoke(Command $command): array
            {
                return [$command->test];
            }
        });

        $commandBus = new CommandBus(
            [
                \stdClass::class => 'test_command_handler',
            ],
            $container->reveal()
        );

        $command = new TestCommand();
        $command->test = 'foo';

        $commandBus->dispatch($command);
    }

    public function testCannotDispatchToAnInvalidHandler(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(TestCommand::class.' has an invalid command handler.');

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('test_command_handler')->willReturn(new class() {
            /** @param TestCommand $command */
            public function __invoke(Command $command): array
            {
                return [$command->test];
            }
        });
        $container->has('test_command_handler')->willReturn(true);

        $commandBus = new CommandBus(
            [
                TestCommand::class => 'test_command_handler',
            ],
            $container->reveal()
        );

        $command = new TestCommand();
        $command->test = 'foo';

        $commandBus->dispatch($command);
    }

    public function testCannotDispatchToANotRegisteredCommandHandler(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('test_command_handler is not a registered container service.');

        $container = $this->prophesize(ContainerInterface::class);
        $container->has('test_command_handler')->willReturn(false);

        $commandBus = new CommandBus(
            [
                TestCommand::class => 'test_command_handler',
            ],
            $container->reveal()
        );

        $command = new TestCommand();
        $command->test = 'foo';

        $commandBus->dispatch($command);
    }
}
