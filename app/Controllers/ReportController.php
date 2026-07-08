<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\{BookService, BorrowingService};

class ReportController
{
    public function overdue(): void {
        (new BorrowingService())->refreshOverdue();
        $books     = (new BookService())->overdue();
        $pageTitle = 'Overdue Books';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/reports/overdue_report.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function mostBorrowed(): void {
        $books     = (new BookService())->mostBorrowed(20);
        $pageTitle = 'Most Borrowed Books';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/reports/most_borrowed_report.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function availability(): void {
        $books     = (new BookService())->availability();
        $pageTitle = 'Book Availability';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/reports/availability_report.php';
        require BASE_PATH . '/includes/footer.php';
    }
}
