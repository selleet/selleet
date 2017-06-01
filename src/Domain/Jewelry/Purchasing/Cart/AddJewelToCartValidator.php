<?php

namespace Selleet\Domain\Jewelry\Purchasing\Cart;

use Selleet\Domain\BuildingBlocks\Command\Validation\CommandValidator;
use Selleet\Domain\BuildingBlocks\Command\Validation\ValidationResult;

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
