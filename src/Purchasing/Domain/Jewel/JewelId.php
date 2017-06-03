<?php

namespace Selleet\Purchasing\Domain\Jewel;

use Selleet\BuildingBlocks\ValueObjectIdentifier;
use Selleet\BuildingBlocks\ValueObjectUuidTrait;

final class JewelId implements ValueObjectIdentifier
{
    use ValueObjectUuidTrait;
}
