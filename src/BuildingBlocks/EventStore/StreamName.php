<?php

namespace Selleet\BuildingBlocks\EventStore;

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

    public static function fromAliasAndId($alias, $aggregateRootId)
    {
        return new self($alias.'_'.$aggregateRootId);
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
