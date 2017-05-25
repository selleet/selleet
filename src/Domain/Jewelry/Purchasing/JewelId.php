<?php

namespace Selleet\Domain\Jewelry\Purchasing;

use Selleet\Domain\BuildingBlocks\ValueObjectIdentifier;
use Selleet\Domain\BuildingBlocks\ValueObjectUuidTrait;

final class JewelId implements ValueObjectIdentifier
{
    use ValueObjectUuidTrait;
}
