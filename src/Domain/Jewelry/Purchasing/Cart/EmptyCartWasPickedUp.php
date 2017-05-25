<?php

namespace Selleet\Domain\Jewelry\Purchasing\Cart;

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
}
