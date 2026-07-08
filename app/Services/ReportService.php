<?php
declare(strict_types=1);

namespace App\Services;

use App\Config\Database;

class ReportService
{
    /** Dashboard stats in one pass. */
    public function dashboardStats(): array
    {
        $db = Database::connection();
        return [
            'total_books'    => (int)$db->query('SELECT COUNT(*) FROM books')->fetchColumn(),
            'total_members'  => (int)$db->query('SELECT COUNT(*) FROM members')->fetchColumn(),
            'active_loans'   => (int)$db->query("SELECT COUNT(*) FROM borrowings WHERE status IN ('borrowed','overdue')")->fetchColumn(),
            'overdue_loans'  => (int)$db->query("SELECT COUNT(*) FROM borrowings WHERE status = 'overdue'")->fetchColumn(),
            'unpaid_fines'   => (float)$db->query("SELECT COALESCE(SUM(amount),0) FROM fines WHERE status='unpaid'")->fetchColumn(),
            'total_librarians' => (int)$db->query('SELECT COUNT(*) FROM librarians')->fetchColumn(),
        ];
    }

    /** Recent activity for the dashboard feed. */
    public function recentActivity(int $limit = 10): array
    {
        $db = Database::connection();
        $stmt = $db->prepare(
            'SELECT action, table_name, details, created_at FROM audit_logs
              ORDER BY created_at DESC LIMIT :lim'
        );
        $stmt->bindValue(':lim', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
