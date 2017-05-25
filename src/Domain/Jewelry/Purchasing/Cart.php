<?php

namespace Selleet\Domain\Jewelry\Purchasing;

use Selleet\Domain\BuildingBlocks\AggregateRoot;
use Selleet\Domain\BuildingBlocks\AggregateRootTrait;
use Selleet\Domain\BuildingBlocks\DomainEvent;
use Selleet\Domain\BuildingBlocks\UnknownDomainEventRecorded;

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

    private function __construct() {}

    public static function pickUp(CartId $cartId)
    {
        $self = new self();
        $self->recordThat(new EmptyCartWasPickedUp($cartId));

        return $self;

    }

    public function add(JewelId $jewelId, int $price): void
    {
        $this->recordThat(new JewelWasAddedToTheCart($this->id, $jewelId, $price));
    }

    public function totalPrice(): int
    {
        return $this->totalPrice;
    }

    public function getAggregateId(): CartId
    {
        return $this->id;
    }

    public function apply(DomainEvent $event): void
    {
        switch ($event) {
            case $event instanceof EmptyCartWasPickedUp:
                $this->id = $event->getAggregateId();
                $this->jewels = [];
                $this->totalPrice = 0;
                break;
            case $event instanceof JewelWasAddedToTheCart:
                $this->jewels[] = $event->getJewelId();
                $this->totalPrice += $event->getPrice();
                break;
            default:
                throw UnknownDomainEventRecorded::withEvent($event);
        }
    }
}
