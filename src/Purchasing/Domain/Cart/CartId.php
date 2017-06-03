<?php

namespace Selleet\Purchasing\Domain\Cart;

use Selleet\BuildingBlocks\ValueObjectIdentifier;
use Selleet\BuildingBlocks\ValueObjectUuidTrait;

final class CartId implements ValueObjectIdentifier
{
    use ValueObjectUuidTrait;
}
