<?php

namespace Selleet\Domain\BuildingBlocks;

interface DomainEvent
{
    /**
     * @return mixed|ValueObjectIdentifier
     */
    public function getAggregateId();
}
