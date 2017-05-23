<?php

namespace Selleet\Domain\BuildingBlocks;

interface DomainEvent
{
    public function getAggregateId(): ValueObjectIdentifier;
}
