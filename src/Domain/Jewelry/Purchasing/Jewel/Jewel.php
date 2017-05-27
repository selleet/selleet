<?php

namespace Selleet\Domain\Jewelry\Purchasing\Jewel;

use Selleet\Domain\BuildingBlocks\AggregateRoot;
use Selleet\Domain\BuildingBlocks\AggregateRootTrait;
use Selleet\Domain\BuildingBlocks\DomainEvent;
use Selleet\Domain\BuildingBlocks\UnknownDomainEventRecorded;

final class Jewel implements AggregateRoot
{
    use AggregateRootTrait;

    private $id;
    private $title;
    private $price;

    private function __construct()
    {
    }

    public static function titledAndPriced(JewelId $id, string $title, int $price): self
    {
        return (new self())->recordThat(new NewJewelWasOut($id, $title, $price));
    }

    public function price(): int
    {
        return $this->price;
    }

    public function getAggregateId(): JewelId
    {
        return $this->id;
    }

    public function apply(DomainEvent $event): self
    {
        $self = clone $this;

        switch ($event) {
            case $event instanceof NewJewelWasOut:
                $self->id = $event->getAggregateId();
                $self->title = $event->getTitle();
                $self->price = $event->getPrice();
                break;
            default:
                throw UnknownDomainEventRecorded::withEvent($event);
        }

        return $self;
    }
}
