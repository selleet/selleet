<?php

namespace Selleet\BuildingBlocks\EventStore;

use Selleet\BuildingBlocks\DomainEvent;

class Stream
{
    private $streamName;
    private $streamEvents;

    public function __construct(StreamName $streamName, iterable $streamEvents)
    {
        $this->streamName = $streamName;
        $this->streamEvents = $streamEvents;
    }

    public function getStreamName(): StreamName
    {
        return $this->streamName;
    }

    /**
     * @return DomainEvent[]
     */
    public function getStreamEvents(): iterable
    {
        return $this->streamEvents;
    }

    public function isEmpty(): bool
    {
        return empty($this->streamEvents);
    }
}
