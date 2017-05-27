<?php

namespace Selleet\Domain\Jewelry\Purchasing\Cart;

interface CartRepository
{
    public function get(CartId $cartId): Cart;

    public function save(Cart $cart): void;
}
