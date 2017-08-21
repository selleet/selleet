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
        $errors = [];

        if ($command->price <= 0) {
            $errors['price'] = [
                'Price cannot be lower than 0.'
            ];
        }

        return new ValidationResult($errors);
    }
}
