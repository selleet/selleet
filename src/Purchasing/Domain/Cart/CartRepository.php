<?php

namespace Selleet\Purchasing\Domain\Cart;

interface CartRepository
{
    public function get(CartId $cartId): Cart;

    public function save(Cart $cart): void;
}
