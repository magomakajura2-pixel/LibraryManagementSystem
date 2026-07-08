<?php
declare(strict_types=1);

namespace App\Validators;

class BookValidator extends Validator
{
    public function validate(array $data): bool
    {
        $this->errors = [];
        $this->required($data, 'isbn',  'ISBN');
        $this->required($data, 'title', 'Title');
        $this->required($data, 'author','Author');
        $this->maxLength($data, 'isbn',   20, 'ISBN');
        $this->maxLength($data, 'title', 255, 'Title');
        $this->maxLength($data, 'author',150, 'Author');
        $this->numeric($data,   'total_copies', 'Total copies');
        $this->minValue($data,  'total_copies', 1, 'Total copies');
        return empty($this->errors);
    }
}
