<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Book;

class BookService
{
    private Book $book;
    public function __construct() { $this->book = new Book(); }

    public function all(): array       { return $this->book->all('title'); }
    public function find(int $id): ?array { return $this->book->find($id); }
    public function add(array $data): int { return $this->book->add($data); }
    public function edit(int $id, array $data): int { return $this->book->edit($id, $data); }
    public function delete(int $id): int  { return $this->book->removeIfNotOnLoan($id); }
    public function search(string $term): array { return $this->book->search($term); }
    public function overdue(): array   { return $this->book->overdue(); }
    public function mostBorrowed(int $limit = 10): array { return $this->book->mostBorrowed($limit); }
    public function borrowedCount(): int { return $this->book->borrowedCount(); }
    public function availability(): array { return $this->book->availability(); }

    /** Get categories for dropdowns. */
    public function categories(): array
    {
        $db = \App\Config\Database::connection();
        return $db->query('SELECT category_id, name FROM categories ORDER BY name')->fetchAll();
    }
}
