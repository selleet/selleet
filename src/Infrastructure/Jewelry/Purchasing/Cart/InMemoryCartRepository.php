<?php

namespace Selleet\Infrastructure\Jewelry\Purchasing\Cart;

use Selleet\Domain\Jewelry\Purchasing\Cart\Cart;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartId;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartRepository;

class InMemoryCartRepository implements CartRepository
{
    /**
     * @var Cart[CartId]
     */
    private $carts;

    public function get(CartId $cartId): Cart
    {
        return $this->carts[$cartId->toString()];
    }

    public function save(Cart $cart): void
    {
        $this->carts[$cart->getAggregateId()->toString()] = $cart;
    }
}
