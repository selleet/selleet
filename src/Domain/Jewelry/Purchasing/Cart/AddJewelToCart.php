<?php

namespace Selleet\Domain\Jewelry\Purchasing\Cart;

use Selleet\Domain\BuildingBlocks\Command\Command;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelId;

final class AddJewelToCart implements Command
{
    public $cartId;
    public $jewelId;
    public $price;

    public function __construct(CartId $cartId, JewelId $jewelId, int $price)
    {
        $this->cartId = $cartId;
        $this->jewelId = $jewelId;
        $this->price = $price;
    }
}
