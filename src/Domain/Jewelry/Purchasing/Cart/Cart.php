<?php

namespace Selleet\Domain\Jewelry\Purchasing\Cart;

use Selleet\Domain\BuildingBlocks\AggregateRoot;
use Selleet\Domain\BuildingBlocks\AggregateRootTrait;
use Selleet\Domain\BuildingBlocks\DomainEvent;
use Selleet\Domain\BuildingBlocks\UnknownDomainEventRecorded;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelId;

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
        $self = new self();
        $self->recordThat(new EmptyCartWasPickedUp($cartId));

        return $self;
    }

    public function add(JewelId $jewelId, int $price): self
    {
        return $this->recordThat(new JewelWasAddedToTheCart($this->id, $jewelId, $price));
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
                $self = clone $this;
                $self->id = $event->getAggregateId();
                $self->jewels = [];
                $self->totalPrice = 0;
                break;
            case $event instanceof JewelWasAddedToTheCart:
                $self = clone $this;
                $self->jewels[] = $event->getJewelId();
                $self->totalPrice += $event->getPrice();
                break;
            default:
                throw UnknownDomainEventRecorded::withEvent($event);
        }

        return $self;
    }
}
