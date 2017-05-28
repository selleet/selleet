<?php

namespace SelleetTest\Infrastructure\BuildingBlocks\EventStore;

use PHPUnit\Framework\TestCase;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartId;
use Selleet\Domain\Jewelry\Purchasing\Cart\EmptyCartWasPickedUp;
use Selleet\Domain\Jewelry\Purchasing\Cart\JewelWasAddedToCart;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelId;
use Selleet\Infrastructure\BuildingBlocks\EventStore\EventStore;
use Selleet\Infrastructure\BuildingBlocks\EventStore\InFileEventStore;
use Selleet\Infrastructure\BuildingBlocks\EventStore\Stream;
use Selleet\Infrastructure\BuildingBlocks\EventStore\StreamName;

/**
 * @covers \Selleet\Infrastructure\BuildingBlocks\EventStore\InFileEventStore
 */
final class InFileEventStoreTest extends TestCase
{
    private $directory;

    protected function setUp()
    {
        $this->directory = __DIR__.'/../../../../var/tests/eventstore';
    }

    public function testCanBeCreatedWithAValidDirectory(): void
    {
        $this->assertInstanceOf(
            EventStore::class,
            new InFileEventStore($this->directory)
        );
    }

    public function testCanCommitEventStream(): void
    {
        $eventStore = new InFileEventStore($this->directory);

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
}
