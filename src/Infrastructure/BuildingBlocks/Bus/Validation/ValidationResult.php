<?php

namespace Selleet\Infrastructure\BuildingBlocks\Bus\Validation;

final class ValidationResult
{
    private $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function isValid(): bool
    {
        return 0 === count($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
