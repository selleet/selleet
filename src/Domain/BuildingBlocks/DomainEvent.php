<?php

namespace Selleet\Domain\BuildingBlocks;

use DateTimeInterface;
use Serializable;

interface DomainEvent extends Serializable
{
    /**
     * @return mixed|ValueObjectIdentifier
     */
    public function getAggregateId();

    /**
     * @return string AggregateRoot FQCN
     */
    public function getAggregateType(): string;

    /**
     * @return DateTimeInterface Datetime when the event occurred
     */
    public function getDateTime(): DateTimeInterface;
}
