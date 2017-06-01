<?php

namespace Selleet\Infrastructure\Jewelry\Purchasing\Cart;

use Selleet\Domain\Jewelry\Purchasing\Cart\AddJewelToCart;
use Selleet\Infrastructure\BuildingBlocks\Bus\Validation\CommandValidator;
use Selleet\Infrastructure\BuildingBlocks\Bus\Validation\ValidationResult;

class AddJewelToCartValidator implements CommandValidator
{
    /**
     * @param AddJewelToCart $command
     *
     * @return array Errors
     */
    public function validate($command): ValidationResult
    {
        return new ValidationResult([]);
    }
}
