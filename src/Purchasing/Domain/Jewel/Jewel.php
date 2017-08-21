<?php

namespace Selleet\Purchasing\Domain\Jewel;

use Selleet\BuildingBlocks\Aggregate\AggregateRoot;
use Selleet\BuildingBlocks\Aggregate\AggregateRootTrait;
use Selleet\BuildingBlocks\Aggregate\DomainEvent;
use Selleet\BuildingBlocks\Aggregate\UnknownDomainEventRecorded;

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
        switch ($event) {
            case $event instanceof NewJewelWasOut:
                $this->id = $event->getAggregateId();
                $this->title = $event->getTitle();
                $this->price = $event->getPrice();
                break;
            default:
                throw UnknownDomainEventRecorded::withEvent($event);
        }

        return $this;
    }
}
