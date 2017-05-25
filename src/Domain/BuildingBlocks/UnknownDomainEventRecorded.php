<?php

namespace Selleet\Domain\BuildingBlocks;

final class UnknownDomainEventRecorded extends \RuntimeException
{
    public static function withEvent($event): self
    {
        return new self(sprintf(
            'Tried to record an unknown domain event (%s).',
            get_class($event)
        ));
    }
}
