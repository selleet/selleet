<?php

namespace Selleet\Infrastructure\Jewelry\Purchasing\Cart;

use Selleet\Domain\Jewelry\Purchasing\Cart\AddJewelToCart;
use Selleet\Infrastructure\BuildingBlocks\Bus\CommandValidator;

class AddJewelToCartValidator implements CommandValidator
{
    /**
     * @param AddJewelToCart $command
     *
     * @return array Errors
     */
    public function validate($command): array
    {
        return [];
    }
}
