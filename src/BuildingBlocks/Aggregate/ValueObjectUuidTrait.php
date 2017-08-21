<?php

namespace Selleet\BuildingBlocks\Aggregate;

trait ValueObjectUuidTrait
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

    public function getId(): Uuid
    {
        return $this->uuid;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function sameValueAs(ValueObjectIdentifier $other): bool
    {
        return get_class($this) === get_class($other) && $this->uuid->equals($other->getId());
    }
}
