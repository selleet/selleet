<?php

namespace Selleet\Purchasing\Domain\Cart;

use Selleet\BuildingBlocks\AggregateRoot;
use Selleet\BuildingBlocks\AggregateRootTrait;
use Selleet\BuildingBlocks\DomainEvent;
use Selleet\BuildingBlocks\UnknownDomainEventRecorded;
use Selleet\Purchasing\Domain\Jewel\JewelId;

final class Cart implements AggregateRoot
{
    use AggregateRootTrait;

    /**
     * @var CartId
     */
    private $id;

    /**
     * @var JewelId[]
     */
    private $jewels;

    /**
     * @var int
     */
    private $totalPrice;

    private function __construct()
    {
    }

    public static function pickUp(CartId $cartId): self
    {
        return (new self())->recordThat(new EmptyCartWasPickedUp($cartId));
    }

    public function add(JewelId $jewelId, int $price): self
    {
        return $this->recordThat(new JewelWasAddedToCart($this->id, $jewelId, $price));
    }

    public function totalPrice(): int
    {
        return $this->totalPrice;
    }

    public function getAggregateId(): CartId
    {
        return $this->id;
    }

    public function apply(DomainEvent $event): self
    {
        switch ($event) {
            case $event instanceof EmptyCartWasPickedUp:
                $this->id = $event->getAggregateId();
                $this->jewels = [];
                $this->totalPrice = 0;
                break;
            case $event instanceof JewelWasAddedToCart:
                $this->jewels[] = $event->getJewelId();
                $this->totalPrice += $event->getPrice();
                break;
            default:
                throw UnknownDomainEventRecorded::withEvent($event);
        }

        return $this;
    }
}
