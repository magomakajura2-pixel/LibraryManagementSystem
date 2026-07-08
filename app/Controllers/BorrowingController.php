<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\{BorrowingService, BookService, MemberService, LibrarianService};
use App\Validators\BorrowingValidator;
use App\Helpers\{Session, Flash, Redirect};

class BorrowingController
{
    private BorrowingService $svc;
    public function __construct() { $this->svc = new BorrowingService(); }

    public function index(): void {
        $loans     = $this->svc->active();
        $pageTitle = 'Active Loans';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/borrowings/view_borrowings_page.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function create(): void {
        $books      = (new BookService())->all();
        $members    = (new MemberService())->all();
        $librarians = (new LibrarianService())->all();
        $pageTitle  = 'Issue Book';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/borrowings/issue_book_form.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function store(): void {
        $v = new BorrowingValidator();
        if (!$v->validate($_POST)) { Redirect::withError('/borrowings/issue_book.php', $v->firstError()); }

        $result = $this->svc->borrow(
            (int)$_POST['book_id'],
            (int)$_POST['member_id'],
            !empty($_POST['librarian_id']) ? (int)$_POST['librarian_id'] : null,
            (int)($_POST['loan_days'] ?: DEFAULT_LOAN_DAYS)
        );

        if ($result['ok']) {
            Redirect::withSuccess('/borrowings/view_borrowings.php', $result['message']);
        } else {
            Redirect::withError('/borrowings/issue_book.php', $result['message']);
        }
    }
}
