<?php

namespace Selleet\Domain\Jewelry\Purchasing;

use Selleet\Domain\BuildingBlocks\DomainEvent;

final class JewelWasAddedToTheCart implements DomainEvent
{
    private $id;
    private $jewel;

    public function __construct(CartId $id, Jewel $jewel)
    {
        $this->id = $id;
        $this->jewel = $jewel;
    }

    public function getId(): CartId
    {
        return $this->id;
    }

    public function getJewel(): Jewel
    {
        return $this->jewel;
    }
}
