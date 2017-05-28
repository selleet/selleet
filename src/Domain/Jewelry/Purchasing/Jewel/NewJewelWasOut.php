<?php

namespace Selleet\Domain\Jewelry\Purchasing\Jewel;

use DateTimeInterface;
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

    public function getAggregateType(): string
    {
        return Jewel::class;
    }

    public function getDateTime(): DateTimeInterface
    {
        return new \DateTimeImmutable();
    }

    public function serialize()
    {
        return json_encode([
            'jewelId' => $this->jewelId->toString(),
            'title' => $this->title,
            'price' => $this->price,
        ]);
    }

    public function unserialize($serialized)
    {
        $unserialized = json_decode($serialized);

        $this->jewelId = JewelId::fromString($unserialized->jewelId);
        $this->title = $unserialized->title;
        $this->price = $unserialized->price;
    }
}
