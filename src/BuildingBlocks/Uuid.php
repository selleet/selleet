<?php

namespace Selleet\BuildingBlocks;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface as RamseyUuidInterface;

final class Uuid
{
    /**
     * @var RamseyUuidInterface
     */
    private $uuidImplementation;

    private function __construct(RamseyUuidInterface $uuidImplementation)
    {
        $this->uuidImplementation = $uuidImplementation;
    }

    public static function uuid4(): self
    {
        return new self(RamseyUuid::getFactory()->uuid4());
    }

    public function toString(): string
    {
        return $this->uuidImplementation->toString();
    }

    public function equals(Uuid $other): bool
    {
        return $this->uuidImplementation->equals($other->uuidImplementation);
    }

    public static function fromString(string $uuid): self
    {
        return new self(RamseyUuid::getFactory()->fromString($uuid));
    }
}
