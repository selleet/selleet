<?php

namespace SelleetTest\Infrastructure\BuildingBlocks\Bus;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Selleet\Domain\BuildingBlocks\Command\CommandHandler;
use Selleet\Infrastructure\BuildingBlocks\Bus\CommandBus;
use Selleet\Infrastructure\BuildingBlocks\Bus\CommandSyncDispatcherMiddleware;
use Selleet\Infrastructure\BuildingBlocks\Bus\CommandValidatorMiddleware;

/**
 * @covers \Selleet\Infrastructure\BuildingBlocks\Bus\CommandBus
 */
final class CommandBusTest extends TestCase
{
    public function testCanBeCreatedFromValidHandlers(): void
    {
        $this->assertInstanceOf(
            CommandBus::class,
            new CommandBus([
                new CommandSyncDispatcherMiddleware(
                    [
                        TestCommand::class => 'test_command_handler',
                    ],
                    $this->prophesize(ContainerInterface::class)->reveal()
                ),
            ])
        );
    }

    public function testCanDispatchACommand(): void
    {
        $command = new TestCommand();
        $command->test = 'foo';

        $commandHandler = $this->getMockBuilder(CommandHandler::class)
            ->setMethods(['__invoke'])
            ->getMock();

        $commandHandler->expects($this->once())
            ->method('__invoke')
            ->with($command);

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('test_command_handler')->willReturn($commandHandler);
        $container->has('test_command_handler')->willReturn(true);

        $commandBus = new CommandBus([
            new CommandSyncDispatcherMiddleware(
                [
                    TestCommand::class => 'test_command_handler',
                ],
                $container->reveal()
            ),
        ]);

        $commandBus->dispatch($command);
    }

    public function testCanDispatchAValidCommand(): void
    {
        $command = new TestCommand();
        $command->test = 'foo';

        $commandHandler = $this->getMockBuilder(CommandHandler::class)
            ->setMethods(['__invoke'])
            ->getMock();

        $commandHandler->expects($this->once())
            ->method('__invoke')
            ->with($command);

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('test_command_handler')->willReturn($commandHandler);
        $container->has('test_command_handler')->willReturn(true);

        $commandBus = new CommandBus([
            new CommandValidatorMiddleware([
                TestCommand::class => new TestCommandValidator(),
            ]),
            new CommandSyncDispatcherMiddleware(
                [
                    TestCommand::class => 'test_command_handler',
                ],
                $container->reveal()
            ),
        ]);

        $commandBus->dispatch($command);
    }

    public function testCannotDispatchANotRegisteredCommand(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Command '.TestCommand::class.' not registered.');

        $commandHandler = $this->getMockBuilder(CommandHandler::class)
            ->setMethods(['__invoke'])
            ->getMock();

        $commandHandler->expects($this->never())
            ->method('__invoke');

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('test_command_handler')->willReturn($commandHandler);

        $commandBus = new CommandBus([
            new CommandSyncDispatcherMiddleware(
                [
                    \stdClass::class => 'test_command_handler',
                ],
                $container->reveal()
            ),
        ]);

        $command = new TestCommand();
        $command->test = 'foo';

        $commandBus->dispatch($command);
    }

    public function testCannotDispatchToAnInvalidHandler(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(TestCommand::class.' has an invalid command handler.');

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('test_command_handler')->willReturn(new \stdClass());
        $container->has('test_command_handler')->willReturn(true);

        $commandBus = new CommandBus([
            new CommandSyncDispatcherMiddleware(
                [
                    TestCommand::class => 'test_command_handler',
                ],
                $container->reveal()
            ),
        ]);

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

        $commandBus = new CommandBus([
            new CommandSyncDispatcherMiddleware(
                [
                    TestCommand::class => 'test_command_handler',
                ],
                $container->reveal()
            ),
        ]);

        $command = new TestCommand();
        $command->test = 'foo';

        $commandBus->dispatch($command);
    }
}
