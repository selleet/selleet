<?php

namespace Selleet\Purchasing\Domain\Cart;

use DateTimeInterface;
use Selleet\BuildingBlocks\Aggregate\DomainEvent;
use Selleet\Purchasing\Domain\Jewel\JewelId;

final class JewelWasAddedToCart implements DomainEvent
{
    private $cartId;
    private $jewelId;
    private $price;

    public function __construct(CartId $cartId, JewelId $jewelId, int $price)
    {
        $this->cartId = $cartId->toString();
        $this->jewelId = $jewelId->toString();
        $this->price = $price;
    }

    public function getAggregateId(): CartId
    {
        return CartId::fromString($this->cartId);
    }

    public function getJewelId(): JewelId
    {
        return JewelId::fromString($this->jewelId);
    }

    public function getPrice(): int
    {
        return $this->price;
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
            'cartId' => $this->cartId,
            'jewelId' => $this->jewelId,
            'price' => $this->price,
        ]);
    }

    public function unserialize($serialized)
    {
        $unserialized = json_decode($serialized);

        $this->cartId = $unserialized->cartId;
        $this->jewelId = $unserialized->jewelId;
        $this->price = $unserialized->price;
    }
}
