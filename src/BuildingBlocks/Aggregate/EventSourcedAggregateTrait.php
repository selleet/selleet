<?php

namespace Selleet\BuildingBlocks\Aggregate;

trait EventSourcedAggregateTrait
{
    /**
     * @var DomainEvent[]
     */
    private $recordedEvents = [];

    public function getAggregateId()
    {
        return $this->id;
    }

    /**
     * @param DomainEvent[] $historyEvents
     */
    public static function reconstituteFromHistory(iterable $historyEvents)
    {
        $aggregateRoot = new static();

        foreach ($historyEvents as $pastEvent) {
            $aggregateRoot = $aggregateRoot->apply($pastEvent);
        }

        return $aggregateRoot;
    }

    /**
     * @return DomainEvent[]
     */
    public function getRecordedEvents(): array
    {
        return $this->recordedEvents;
    }

    abstract public function apply(DomainEvent $event);

    private function recordThat(DomainEvent $event)
    {
        $this->recordedEvents[] = $event;

        return $this->apply($event);
    }
}
