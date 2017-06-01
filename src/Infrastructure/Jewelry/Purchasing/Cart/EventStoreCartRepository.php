<?php

namespace Selleet\Infrastructure\Jewelry\Purchasing\Cart;

use Selleet\Domain\Jewelry\Purchasing\Cart\Cart;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartId;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartRepository;
use Selleet\Infrastructure\BuildingBlocks\EventStore\EventStore;
use Selleet\Infrastructure\BuildingBlocks\EventStore\Stream;
use Selleet\Infrastructure\BuildingBlocks\EventStore\StreamName;

final class EventStoreCartRepository implements CartRepository
{
    private const ALIAS = 'purchasing_cart';

    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function get(CartId $cartId): Cart
    {
        $stream = $this->eventStore->load(
            StreamName::fromAliasAndId(self::ALIAS, $cartId->toString())
        );

        return Cart::reconstituteFromHistory($stream->getStreamEvents());
    }

    public function save(Cart $cart): void
    {
        $this->eventStore->commit(new Stream(
            StreamName::fromAliasAndId(self::ALIAS, $cart->getAggregateId()->toString()),
            $cart->getRecordedEvents()
        ));
    }
}
