<?php

namespace Selleet\Domain\Jewelry\Purchasing\Jewel;

use Selleet\Domain\BuildingBlocks\DomainEvent;

final class NewJewelWasOut implements DomainEvent
{
    private $jewelId;
    private $title;
    private $price;

    public function __construct(JewelId $jewelId, string $title, int $price)
    {
        $this->jewelId = $jewelId;
        $this->title = $title;
        $this->price = $price;
    }

    public function getAggregateId(): JewelId
    {
        return $this->jewelId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
