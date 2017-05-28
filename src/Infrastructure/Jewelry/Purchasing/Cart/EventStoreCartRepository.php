<?php

namespace Selleet\Infrastructure\Jewelry\Purchasing\Cart;

use Selleet\Domain\Jewelry\Purchasing\Cart\Cart;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartId;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartRepository;
use Selleet\Infrastructure\BuildingBlocks\EventStore\EventStore;
use Selleet\Infrastructure\BuildingBlocks\EventStore\Stream;
use Selleet\Infrastructure\BuildingBlocks\EventStore\StreamName;

class EventStoreCartRepository implements CartRepository
{
    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function get(CartId $cartId): Cart
    {
        $stream = $this->eventStore->load(
            StreamName::fromAggregateRoot(Cart::class, $cartId->toString())
        );

        return Cart::reconstituteFromHistory($stream->getStreamEvents());
    }

    public function save(Cart $cart): void
    {
        $this->eventStore->commit(new Stream(
            StreamName::fromAggregateRoot(Cart::class, $cart->getAggregateId()->toString()),
            $cart->getRecordedEvents()
        ));
    }
}
