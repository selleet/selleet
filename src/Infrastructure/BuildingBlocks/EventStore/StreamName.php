<?php

namespace Selleet\Infrastructure\BuildingBlocks\EventStore;

class StreamName
{
    private $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Stream name must not be empty.');
        }

        $this->name = $name;
    }

    public static function fromAggregateRoot(string $aggregateRootFQCN, string $aggregateRootId)
    {
        $fqcnParts = array_reverse(explode('\\', $aggregateRootFQCN));
        $aggregateName = strtolower($fqcnParts[0]);

        return new self($aggregateName.'_'.$aggregateRootId);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
