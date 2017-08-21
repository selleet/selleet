<?php

namespace Selleet\Purchasing\Domain\Jewel;

use Selleet\BuildingBlocks\Aggregate\ValueObjectIdentifier;
use Selleet\BuildingBlocks\Aggregate\ValueObjectUuidTrait;

final class JewelId implements ValueObjectIdentifier
{
    use ValueObjectUuidTrait;
}
