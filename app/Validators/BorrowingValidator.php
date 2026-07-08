<?php
declare(strict_types=1);

namespace App\Validators;

class BorrowingValidator extends Validator
{
    public function validate(array $data): bool
    {
        $this->errors = [];
        $this->required($data, 'book_id',   'Book');
        $this->required($data, 'member_id', 'Member');
        $this->numeric($data,  'book_id',   'Book');
        $this->numeric($data,  'member_id', 'Member');
        if (!empty($data['loan_days'])) {
            $this->numeric($data,  'loan_days', 'Loan days');
            $this->minValue($data, 'loan_days', 1, 'Loan days');
        }
        return empty($this->errors);
    }
}
