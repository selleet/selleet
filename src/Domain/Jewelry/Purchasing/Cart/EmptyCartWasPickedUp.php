<?php

namespace Selleet\Domain\Jewelry\Purchasing\Cart;

use DateTimeInterface;
use Selleet\Domain\BuildingBlocks\DomainEvent;

final class EmptyCartWasPickedUp implements DomainEvent
{
    private $cartId;

    public function __construct(CartId $cartId)
    {
        $this->cartId = $cartId;
    }

    public function getAggregateId(): CartId
    {
        return $this->cartId;
    }

    public function getAggregateType(): string
    {
        return Cart::class;
    }

    public function getDateTime(): DateTimeInterface
    {
        return new \DateTimeImmutable();
    }

    public function serialize()
    {
        return json_encode([
            'cartId' => $this->cartId->toString(),
        ]);
    }

    public function unserialize($serialized)
    {
        $unserialized = json_decode($serialized);

        $this->cartId = CartId::fromString($unserialized->cartId);
    }
}
