<?php

namespace Selleet\BuildingBlocks\EventStore;

interface EventStore
{
    public function commit(Stream $stream): void;

    public function load(StreamName $streamName): Stream;
}
