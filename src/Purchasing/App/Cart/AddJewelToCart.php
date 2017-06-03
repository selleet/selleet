<?php

namespace Selleet\Purchasing\App\Cart;

use Selleet\BuildingBlocks\Command\Command;
use Selleet\Purchasing\Domain\Cart\CartId;
use Selleet\Purchasing\Domain\Jewel\JewelId;

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
