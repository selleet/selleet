<?php

namespace Selleet\Purchasing\Infrastructure\Cart;

use Selleet\BuildingBlocks\EventStore\EventStore;
use Selleet\BuildingBlocks\EventStore\Stream;
use Selleet\BuildingBlocks\EventStore\StreamName;
use Selleet\Purchasing\Domain\Cart\Cart;
use Selleet\Purchasing\Domain\Cart\CartId;
use Selleet\Purchasing\Domain\Cart\CartNotFound;
use Selleet\Purchasing\Domain\Cart\CartRepository;

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

        if ($stream->isEmpty()) {
            throw CartNotFound::withCartId($cartId);
        }

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
