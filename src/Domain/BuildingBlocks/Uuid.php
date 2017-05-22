<?php

namespace Selleet\Domain\BuildingBlocks;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface as RamseyUuidInterface;

final class Uuid
{
    /**
     * @var RamseyUuidInterface
     */
    private $uuid;

    private function __construct(RamseyUuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function uuid4(): self
    {
        return new self(RamseyUuid::getFactory()->uuid4());
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(Uuid $other): bool
    {
        return $this->uuid->equals($other);
    }

    public static function fromString(string $uuid): self
    {
        return new self(RamseyUuid::getFactory()->fromString($uuid));
    }
}
