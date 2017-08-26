<?php

namespace Selleet\Purchasing\Domain\Jewel;

use Selleet\BuildingBlocks\Aggregate\AggregateRoot;
use Selleet\BuildingBlocks\Aggregate\EventSourcedAggregateTrait;
use Selleet\BuildingBlocks\Aggregate\DomainEvent;
use Selleet\BuildingBlocks\Aggregate\UnknownDomainEventRecorded;

final class Jewel implements AggregateRoot
{
    use EventSourcedAggregateTrait;

    /**
     * @var JewelId
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
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
