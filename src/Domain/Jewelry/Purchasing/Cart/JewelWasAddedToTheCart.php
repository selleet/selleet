<?php

namespace Selleet\Domain\Jewelry\Purchasing\Cart;

use Selleet\Domain\BuildingBlocks\DomainEvent;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelId;

final class JewelWasAddedToTheCart implements DomainEvent
{
    private $cartId;
    private $jewelId;
    private $price;

    public function __construct(CartId $cartId, JewelId $jewelId, int $price)
    {
        $this->cartId = $cartId;
        $this->jewelId = $jewelId;
        $this->price = $price;
    }

    public function getAggregateId(): CartId
    {
        return $this->cartId;
    }

    public function getJewelId(): JewelId
    {
        return $this->jewelId;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
