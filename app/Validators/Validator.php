<?php
declare(strict_types=1);

namespace App\Validators;

/**
 * Base validator — collects errors from child validators.
 */
abstract class Validator
{
    protected array $errors = [];

    abstract public function validate(array $data): bool;

    public function errors(): array { return $this->errors; }

    public function firstError(): ?string
    {
        return $this->errors[0] ?? null;
    }

    protected function required(array $data, string $field, string $label): bool
    {
        if (empty(trim((string)($data[$field] ?? '')))) {
            $this->errors[] = "{$label} is required.";
            return false;
        }
        return true;
    }

    protected function maxLength(array $data, string $field, int $max, string $label): bool
    {
        if (strlen((string)($data[$field] ?? '')) > $max) {
            $this->errors[] = "{$label} must not exceed {$max} characters.";
            return false;
        }
        return true;
    }

    protected function email(array $data, string $field, string $label): bool
    {
        if (!empty($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "{$label} must be a valid email address.";
            return false;
        }
        return true;
    }

    protected function numeric(array $data, string $field, string $label): bool
    {
        if (!empty($data[$field]) && !is_numeric($data[$field])) {
            $this->errors[] = "{$label} must be a number.";
            return false;
        }
        return true;
    }

    protected function minValue(array $data, string $field, int $min, string $label): bool
    {
        if (isset($data[$field]) && (int)$data[$field] < $min) {
            $this->errors[] = "{$label} must be at least {$min}.";
            return false;
        }
        return true;
    }
}
