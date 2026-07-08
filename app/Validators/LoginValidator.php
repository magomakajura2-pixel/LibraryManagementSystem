<?php
declare(strict_types=1);

namespace App\Validators;

class LoginValidator extends Validator
{
    public function validate(array $data): bool
    {
        $this->errors = [];
        $this->required($data, 'username', 'Username');
        $this->required($data, 'password', 'Password');
        return empty($this->errors);
    }
}
