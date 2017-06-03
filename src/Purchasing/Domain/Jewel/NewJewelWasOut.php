<?php

namespace Selleet\Purchasing\Domain\Jewel;

use DateTimeInterface;
use Selleet\BuildingBlocks\DomainEvent;

final class NewJewelWasOut implements DomainEvent
{
    private $jewelId;
    private $title;
    private $price;

    public function __construct(JewelId $jewelId, string $title, int $price)
    {
        $this->jewelId = $jewelId->toString();
        $this->title = $title;
        $this->price = $price;
    }

    public function getAggregateId(): JewelId
    {
        return JewelId::fromString($this->jewelId);
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
            'jewelId' => $this->jewelId,
            'title' => $this->title,
            'price' => $this->price,
        ]);
    }

    public function unserialize($serialized)
    {
        $unserialized = json_decode($serialized);

        $this->jewelId = $unserialized->jewelId;
        $this->title = $unserialized->title;
        $this->price = $unserialized->price;
    }
}
