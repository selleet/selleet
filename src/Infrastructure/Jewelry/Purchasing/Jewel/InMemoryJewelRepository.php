<?php

namespace Selleet\Infrastructure\Jewelry\Purchasing\Jewel;

use Selleet\Domain\Jewelry\Purchasing\Jewel\Jewel;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelId;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelRepository;

class InMemoryJewelRepository implements JewelRepository
{
    /**
     * @var Jewel[JewelId]
     */
    private $jewels;

    public function get(JewelId $jewelId): Jewel
    {
        return $this->jewels[$jewelId->toString()];
    }

    public function save(Jewel $jewel): void
    {
        $this->jewels[$jewel->getAggregateId()->toString()] = $jewel;
    }
}
