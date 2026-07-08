<?php
declare(strict_types=1);

namespace App\Validators;

class LibrarianValidator extends Validator
{
    public function validate(array $data): bool
    {
        $this->errors = [];
        $this->required($data, 'employee_no', 'Employee No.');
        $this->required($data, 'first_name',  'First name');
        $this->required($data, 'last_name',   'Last name');
        $this->required($data, 'user_id',     'User account');
        return empty($this->errors);
    }
}
