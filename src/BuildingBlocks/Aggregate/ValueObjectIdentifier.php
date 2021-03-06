<?php

namespace Selleet\BuildingBlocks\Aggregate;

interface ValueObjectIdentifier
{
    public function getId(): Uuid;

    public function toString(): string;

    public function sameValueAs(ValueObjectIdentifier $other): bool;
}
