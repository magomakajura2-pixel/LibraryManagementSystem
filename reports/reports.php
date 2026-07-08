<?php
$pageTitle = 'Reports';
require_once __DIR__.'/../app/Helpers/Bootstrap.php';
use App\Middleware\Auth; use App\Helpers\Flash;
use App\Services\ReportService;
use App\Models\Book;

Auth::requireRole(['admin','librarian']);

$rpt       = new ReportService();
$bookModel = new Book();

$overdue    = $bookModel->overdue();
$mostBorrow = $bookModel->mostBorrowed(10);
$trend      = $rpt->borrowingTrend();
$byCat      = $rpt->borrowingsByCategory();
$fineSum    = $rpt->fineSummary();
$debtors    = $rpt->topDebtors(10);
$inventory  = $rpt->inventory();

include __DIR__.'/../includes/header.php'; include __DIR__.'/../includes/navbar.php'; include __DIR__.'/../includes/sidebar.php';
?>
<div class="page-wrapper"><main class="main-content">
    <h4 class="fw-bold mb-4"><i class="bi bi-graph-up me-2"></i>Reports</h4>
    <?= Flash::render() ?>

    <!-- Overdue books -->
    <div class="card mb-4">
        <div class="card-header bg-white fw-semibold text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Overdue Books (<?= count($overdue) ?>)</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Title</th><th>Member</th><th>Due Date</th><th class="text-end">Days Overdue</th></tr></thead>
                <tbody>
                <?php if (empty($overdue)): ?><tr><td colspan="4" class="text-center text-muted py-3">None — all books returned on time.</td></tr>
                <?php else: foreach ($overdue as $o): ?>
                    <tr>
                        <td><?= htmlspecialchars($o['title']) ?></td>
                        <td><?= htmlspecialchars($o['member_name']) ?></td>
                        <td><?= $o['due_date'] ?></td>
                        <td class="text-end text-danger fw-bold"><?= $o['days_overdue'] ?></td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <!-- Most borrowed -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white fw-semibold"><i class="bi bi-star me-1"></i>Most Borrowed Books</div>
                <div class="card-body p-0">
                    <table class="table mb-0"><thead class="table-light"><tr><th>#</th><th>Title</th><th>Author</th><th class="text-end">Times</th></tr></thead>
                        <tbody><?php foreach ($mostBorrow as $i => $b): ?>
                            <tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($b['title']) ?></td><td><?= htmlspecialchars($b['author']) ?></td><td class="text-end"><?= $b['times_borrowed'] ?></td></tr>
                        <?php endforeach; ?></tbody></table>
                </div>
            </div>
        </div>
        <!-- By category -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white fw-semibold"><i class="bi bi-tag me-1"></i>Borrowings by Category</div>
                <div class="card-body p-0">
                    <table class="table mb-0"><thead class="table-light"><tr><th>Category</th><th class="text-end">Loans</th></tr></thead>
                        <tbody><?php foreach ($byCat as $c): ?>
                            <tr><td><?= htmlspecialchars($c['category']) ?></td><td class="text-end"><?= $c['loans'] ?></td></tr>
                        <?php endforeach; ?></tbody></table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <!-- Fine summary -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white fw-semibold"><i class="bi bi-cash-coin me-1"></i>Fine Summary</div>
                <div class="card-body p-0">
                    <table class="table mb-0"><thead class="table-light"><tr><th>Status</th><th class="text-end">Count</th><th class="text-end">Total (TZS)</th></tr></thead>
                        <tbody><?php foreach ($fineSum as $f): ?>
                            <tr><td><span class="badge bg-<?= $f['status']==='paid'?'success':($f['status']==='waived'?'secondary':'danger') ?>"><?= $f['status'] ?></span></td>
                                <td class="text-end"><?= $f['cnt'] ?></td><td class="text-end"><?= number_format((float)$f['total']) ?></td></tr>
                        <?php endforeach; ?></tbody></table>
                </div>
            </div>
        </div>
        <!-- Top debtors -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white fw-semibold"><i class="bi bi-person-exclamation me-1"></i>Top Debtors</div>
                <div class="card-body p-0">
                    <table class="table mb-0"><thead class="table-light"><tr><th>Member</th><th class="text-end">Unpaid (TZS)</th></tr></thead>
                        <tbody>
                        <?php if (empty($debtors)): ?><tr><td colspan="2" class="text-center text-muted py-3">No unpaid fines.</td></tr>
                        <?php else: foreach ($debtors as $d): ?>
                            <tr><td><?= htmlspecialchars($d['name']) ?></td><td class="text-end"><?= number_format((float)$d['total_fines']) ?></td></tr>
                        <?php endforeach; endif; ?>
                        </tbody></table>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly trend -->
    <div class="card mb-4">
        <div class="card-header bg-white fw-semibold"><i class="bi bi-bar-chart me-1"></i>Monthly Borrowing Trend</div>
        <div class="card-body p-0">
            <table class="table mb-0"><thead class="table-light"><tr><th>Month</th><th class="text-end">Loans</th></tr></thead>
                <tbody><?php foreach ($trend as $t): ?>
                    <tr><td><?= $t['month'] ?></td><td class="text-end"><?= $t['loans'] ?></td></tr>
                <?php endforeach; ?></tbody></table>
        </div>
    </div>

    <!-- Full inventory -->
    <div class="card">
        <div class="card-header bg-white fw-semibold"><i class="bi bi-list-columns me-1"></i>Full Inventory (<?= count($inventory) ?> titles)</div>
        <div class="card-body p-0">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light"><tr><th>ISBN</th><th>Title</th><th>Author</th><th>Category</th><th class="text-center">Total</th><th class="text-center">Available</th><th class="text-center">On Loan</th><th>Status</th></tr></thead>
                <tbody><?php foreach ($inventory as $v): ?>
                    <tr>
                        <td class="small"><?= htmlspecialchars($v['isbn']) ?></td>
                        <td><?= htmlspecialchars($v['title']) ?></td>
                        <td><?= htmlspecialchars($v['author']) ?></td>
                        <td><?= htmlspecialchars($v['category']??'—') ?></td>
                        <td class="text-center"><?= $v['total_copies'] ?></td>
                        <td class="text-center"><?= $v['available_copies'] ?></td>
                        <td class="text-center"><?= $v['copies_on_loan'] ?></td>
                        <td><span class="badge bg-<?= $v['status']==='available'?'success':'warning' ?>"><?= $v['status'] ?></span></td>
                    </tr>
                <?php endforeach; ?></tbody>
            </table>
        </div>
    </div>

<?php include __DIR__.'/../includes/footer.php'; ?>
