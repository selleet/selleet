<?php

namespace Selleet\Infrastructure\Jewelry\Purchasing\Jewel;

use Selleet\Domain\Jewelry\Purchasing\Jewel\Jewel;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelId;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelRepository;
use Selleet\Infrastructure\BuildingBlocks\EventStore\EventStore;
use Selleet\Infrastructure\BuildingBlocks\EventStore\Stream;
use Selleet\Infrastructure\BuildingBlocks\EventStore\StreamName;

final class EventStoreJewelRepository implements JewelRepository
{
    private const ALIAS = 'purchasing_jewel';

    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function get(JewelId $jewelId): Jewel
    {
        $stream = $this->eventStore->load(
            StreamName::fromAliasAndId(self::ALIAS, $jewelId->toString())
        );

        return Jewel::reconstituteFromHistory($stream->getStreamEvents());
    }

    public function save(Jewel $jewel): void
    {
        $this->eventStore->commit(new Stream(
            StreamName::fromAliasAndId(self::ALIAS, $jewel->getAggregateId()->toString()),
            $jewel->getRecordedEvents()
        ));
    }
}
