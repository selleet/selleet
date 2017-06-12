<?php

namespace Selleet\Purchasing\Domain\Jewel;

use InvalidArgumentException;

final class JewelNotFound extends InvalidArgumentException
{
    public static function withJewelId(JewelId $jewelId): self
    {
        return new self(sprintf('Jewel with id %s cannot be found.', $jewelId->toString()));
    }
}
