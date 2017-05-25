<?php

namespace Selleet\Domain\BuildingBlocks;

trait AggregateRootTrait
{
    /**
     * List of events that are not committed to the EventStore
     *
     * @var DomainEvent[]
     */
    private $recordedEvents = [];

    /**
     * @param iterable|DomainEvent[] $historyEvents
     *
     * @return static
     */
    public static function reconstituteFromHistory(iterable $historyEvents)
    {
        $aggregateRoot = new static();

        /** @var DomainEvent $pastEvent */
        foreach ($historyEvents as $pastEvent) {
            $aggregateRoot->apply($pastEvent);
        }

        return $aggregateRoot;
    }

    /**
     * Get pending events and reset stack
     *
     * @return DomainEvent[]
     */
    public function popRecordedEvents(): array
    {
        $pendingEvents = $this->recordedEvents;

        $this->recordedEvents = [];

        return $pendingEvents;
    }

    abstract public function getAggregateId(): string;

    abstract public function apply(DomainEvent $event): void;

    private function recordThat(DomainEvent $event): void
    {
        $this->recordedEvents[] = $event;

        $this->apply($event);
    }
}
