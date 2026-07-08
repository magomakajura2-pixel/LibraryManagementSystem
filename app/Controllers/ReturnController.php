<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\BorrowingService;
use App\Helpers\{Flash, Redirect};

class ReturnController
{
    private BorrowingService $svc;
    public function __construct() { $this->svc = new BorrowingService(); }

    public function create(): void {
        $loans     = $this->svc->active();
        $pageTitle = 'Return Book';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/returns/return_book_form.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function store(): void {
        $result = $this->svc->returnBook(
            (int)$_POST['borrowing_id'],
            $_POST['book_condition'] ?? 'good',
            !empty($_POST['received_by']) ? (int)$_POST['received_by'] : null
        );
        if ($result['ok']) {
            Redirect::withSuccess('/returns/return_book.php', $result['message']);
        } else {
            Redirect::withError('/returns/return_book.php', $result['message']);
        }
    }
}
