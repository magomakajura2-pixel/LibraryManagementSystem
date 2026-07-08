<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Librarian;

class LibrarianService
{
    private Librarian $librarian;
    public function __construct() { $this->librarian = new Librarian(); }

    public function all(): array          { return $this->librarian->all('last_name'); }
    public function find(int $id): ?array { return $this->librarian->find($id); }
    public function add(array $data): int { return $this->librarian->add($data); }
    public function edit(int $id, array $data): int { return $this->librarian->update($id, $data); }
    public function delete(int $id): int  { return $this->librarian->delete($id); }
}
