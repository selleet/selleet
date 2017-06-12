<?php

namespace Selleet\Purchasing\Domain\Cart;

use InvalidArgumentException;

final class CartNotFound extends InvalidArgumentException
{
    public static function withCartId(CartId $cartId): self
    {
        return new self(sprintf('Cart with id %s cannot be found.', $cartId->toString()));
    }
}
