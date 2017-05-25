<?php

namespace Selleet\Domain\BuildingBlocks;

interface AggregateRoot
{
    public function getAggregateId();
}
