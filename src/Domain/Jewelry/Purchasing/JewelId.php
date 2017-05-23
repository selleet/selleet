<?php

namespace Selleet\Domain\Jewelry\Purchasing;

use Selleet\Domain\BuildingBlocks\ValueObjectIdentifier;
use Selleet\Domain\BuildingBlocks\ValueObjectUuidV4Trait;

final class JewelId implements ValueObjectIdentifier
{
    use ValueObjectUuidV4Trait;
}
