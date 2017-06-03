<?php

namespace Selleet\Purchasing\App\Cart;

use Selleet\BuildingBlocks\Command\Validation\CommandValidator;
use Selleet\BuildingBlocks\Command\Validation\ValidationResult;

final class AddJewelToCartValidator implements CommandValidator
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
