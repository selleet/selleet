<?php

namespace Selleet\Domain\BuildingBlocks;

interface ValueObjectIdentifier
{
    public function getId(): Uuid;
    public function toString(): string;
    public function sameValueAs(ValueObjectIdentifier $other): bool;
}
