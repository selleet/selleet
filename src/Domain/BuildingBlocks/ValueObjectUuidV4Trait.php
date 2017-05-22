<?php

namespace Selleet\Domain\BuildingBlocks;

trait ValueObjectUuidV4Trait
{
    private $uuid;

    private function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    public static function fromString(string $valueObjectId)
    {
        return new static(Uuid::fromString($valueObjectId));
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function sameValueAs($other): bool
    {
        return get_class($this) === get_class($other) && $this->uuid->equals($other->uuid);
    }
}
