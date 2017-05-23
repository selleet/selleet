<?php

namespace Selleet\Domain\Jewelry\Purchasing;

use Selleet\Domain\BuildingBlocks\ValueObjectIdentifier;
use Selleet\Domain\BuildingBlocks\ValueObjectUuidV4Trait;

final class CartId implements ValueObjectIdentifier
{
    use ValueObjectUuidV4Trait;
}
