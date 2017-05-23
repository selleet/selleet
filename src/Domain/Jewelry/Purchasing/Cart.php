<?php

namespace Selleet\Domain\Jewelry\Purchasing;

use Selleet\Domain\BuildingBlocks\DomainEvent;

final class Cart
{
    /**
     * @var CartId
     */
    private $id;

    /**
     * @var Jewel[]
     */
    private $jewels;

    /**
     * @var int
     */
    private $totalPrice;

    private function __construct(CartId $id)
    {
        $this->id = $id;
        $this->jewels = [];
        $this->totalPrice = 0;
    }

    public static function pickUp()
    {
        return new self(CartId::generate());
    }

    public function add(Jewel $jewel): DomainEvent
    {
        $event = new JewelWasAddedToTheCart($this->id, $jewel);

        $this->jewels[] = $jewel;
        $this->totalPrice += $jewel->price();

        return $event;
    }

    public function totalPrice(): int
    {
        return $this->totalPrice;
    }
}
