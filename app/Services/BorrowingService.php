<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Borrowing;

class BorrowingService
{
    private Borrowing $loan;
    public function __construct() { $this->loan = new Borrowing(); }

    public function borrow(int $bookId, int $memberId, ?int $libId, int $days = 14): array
    {
        return $this->loan->borrow($bookId, $memberId, $libId, $days);
    }

    public function returnBook(int $borrowingId, string $condition, ?int $receivedBy): array
    {
        return $this->loan->returnBook($borrowingId, $condition, $receivedBy);
    }

    public function active(): array { return $this->loan->active(); }

    public function refreshOverdue(): void { $this->loan->refreshOverdue(); }

    public function all(): array { return $this->loan->all('borrow_date DESC'); }

    public function find(int $id): ?array { return $this->loan->find($id); }
}
