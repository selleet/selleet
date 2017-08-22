<?php

namespace SelleetTest\BuildingBlocks\EventStore;

use PHPUnit\Framework\TestCase;
use Selleet\BuildingBlocks\EventStore\EventBus;
use Selleet\BuildingBlocks\EventStore\EventDispatcher;
use Selleet\BuildingBlocks\EventStore\EventStore;
use Selleet\BuildingBlocks\EventStore\InFileEventStore;
use Selleet\BuildingBlocks\EventStore\Stream;
use Selleet\BuildingBlocks\EventStore\StreamName;
use Selleet\Purchasing\Domain\Cart\CartId;
use Selleet\Purchasing\Domain\Cart\EmptyCartWasPickedUp;
use Selleet\Purchasing\Domain\Cart\JewelWasAddedToCart;
use Selleet\Purchasing\Domain\Jewel\JewelId;

/**
 * @covers \Selleet\BuildingBlocks\EventStore\InFileEventStore
 */
final class InFileEventStoreTest extends TestCase
{
    private $eventBus;
    private $directory;

    protected function setUp()
    {
        $this->eventBus = $this->prophesize(EventDispatcher::class);
        $this->directory = __DIR__.'/../../../var/tests/eventstore';
    }

    public function testCanBeCreatedWithAValidDirectory(): void
    {
        $this->assertInstanceOf(
            EventStore::class,
            new InFileEventStore($this->eventBus->reveal(), $this->directory)
        );
    }

    public function testCanCommitEventStream(): void
    {
        $eventStore = new InFileEventStore($this->eventBus->reveal(), $this->directory);

        $previousStream = $eventStore->load(new StreamName('test'));
        $numberOfEvents = count($previousStream->getStreamEvents());

        $eventStream = new Stream(new StreamName('test'), [
            new EmptyCartWasPickedUp($cartId = CartId::generate()),
            new JewelWasAddedToCart($cartId, JewelId::generate(), 100),
        ]);

        $eventStore->commit($eventStream);

        $currentEventStream = $eventStore->load(new StreamName('test'));
        $this->assertCount($numberOfEvents + 2, $currentEventStream->getStreamEvents());
    }

    public function testCanDispatchEvents(): void
    {
        $dispatchedEvents = [];

        $eventBus = new EventBus();
        $eventBus->attachListener(EmptyCartWasPickedUp::class, function (EmptyCartWasPickedUp $event) use (&$dispatchedEvents) {
            $dispatchedEvents[] = EmptyCartWasPickedUp::class;
        });
        $eventBus->attachListener(JewelWasAddedToCart::class, function (JewelWasAddedToCart $event) use (&$dispatchedEvents) {
            $dispatchedEvents[] = JewelWasAddedToCart::class;
        });

        $eventStore = new InFileEventStore($eventBus, $this->directory);

        $eventStream = new Stream(new StreamName('test'), [
            new EmptyCartWasPickedUp($cartId = CartId::generate()),
            new JewelWasAddedToCart($cartId, JewelId::generate(), 100),
        ]);

        $eventStore->commit($eventStream);

        $this->assertEquals([EmptyCartWasPickedUp::class, JewelWasAddedToCart::class], $dispatchedEvents);
    }
}
