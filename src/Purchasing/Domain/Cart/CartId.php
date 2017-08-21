<?php

namespace Selleet\Purchasing\Domain\Cart;

use Selleet\BuildingBlocks\Aggregate\ValueObjectIdentifier;
use Selleet\BuildingBlocks\Aggregate\ValueObjectUuidTrait;

final class CartId implements ValueObjectIdentifier
{
    use ValueObjectUuidTrait;
}
