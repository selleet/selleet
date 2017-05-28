<?php

namespace Selleet\Domain\Jewelry\Purchasing\Cart;

use DateTimeInterface;
use Selleet\Domain\BuildingBlocks\DomainEvent;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelId;

final class JewelWasAddedToCart implements DomainEvent
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
            'jewelId' => $this->jewelId->toString(),
            'price' => $this->price,
        ]);
    }

    public function unserialize($serialized)
    {
        $unserialized = json_decode($serialized);

        $this->cartId = CartId::fromString($unserialized->cartId);
        $this->jewelId = JewelId::fromString($unserialized->jewelId);
        $this->price = $unserialized->price;
    }
}
