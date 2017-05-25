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
        $self = new self();
        $self->recordThat(new NewJewelWasOut($id, $title, $price));

        return $self;
    }

    public function price(): int
    {
        return $this->price;
    }

    public function getAggregateId(): JewelId
    {
        return $this->id;
    }

    public function apply(DomainEvent $event): void
    {
        switch ($event) {
            case $event instanceof NewJewelWasOut:
                $this->id = $event->getAggregateId();
                $this->title = $event->getTitle();
                $this->price = $event->getPrice();
                break;
            default:
                throw UnknownDomainEventRecorded::withEvent($event);
        }
    }
}
