<?php

namespace Selleet\Purchasing\Infrastructure\Jewel;

use Selleet\BuildingBlocks\EventStore\EventStore;
use Selleet\BuildingBlocks\EventStore\Stream;
use Selleet\BuildingBlocks\EventStore\StreamName;
use Selleet\Purchasing\Domain\Jewel\Jewel;
use Selleet\Purchasing\Domain\Jewel\JewelId;
use Selleet\Purchasing\Domain\Jewel\JewelRepository;

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
