<?php
declare(strict_types=1);

namespace App\Validators;

class MemberValidator extends Validator
{
    public function validate(array $data): bool
    {
        $this->errors = [];
        $this->required($data, 'membership_no', 'Membership No.');
        $this->required($data, 'first_name',    'First name');
        $this->required($data, 'last_name',     'Last name');
        $this->email($data,    'email',          'Email');
        $this->maxLength($data,'phone', 30,      'Phone');
        return empty($this->errors);
    }
}
