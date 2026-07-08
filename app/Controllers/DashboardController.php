<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\{ReportService, BorrowingService};

class DashboardController
{
    public function index(): void
    {
        $report = new ReportService();

        // Refresh overdue flags first.
        (new BorrowingService())->refreshOverdue();

        $stats    = $report->dashboardStats();
        $activity = $report->recentActivity(8);

        $pageTitle = 'Dashboard';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/dashboard/dashboard_view.php';
        require BASE_PATH . '/includes/footer.php';
    }
}
