<?php use App\Helpers\Flash; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-arrow-right-circle me-2"></i>Active Loans</h4>
        <a href="<?= BASE_URL ?>/borrowings/issue_book.php" class="btn btn-lms btn-sm"><i class="bi bi-box-arrow-up-right me-1"></i> Issue Book</a>
    </div>
    <div class="table-responsive">
        <table class="table table-lms table-hover align-middle">
            <thead><tr><th>#</th><th>Book</th><th>Member</th><th>Borrowed</th><th>Due</th><th>Status</th></tr></thead>
            <tbody>
<?php if (empty($loans)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No active loans.</td></tr>
<?php else: foreach ($loans as $i => $l): ?>
                <tr>
                    <td><?= $l['borrowing_id'] ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($l['title']) ?></td>
                    <td><?= htmlspecialchars($l['member']) ?></td>
                    <td><?= date(DATE_DISPLAY, strtotime($l['borrow_date'])) ?></td>
                    <td><?= date(DATE_DISPLAY, strtotime($l['due_date'])) ?></td>
                    <td><span class="badge <?= $l['status']==='overdue'?'bg-danger':'bg-primary' ?>"><?= $l['status'] ?></span></td>
                </tr>
<?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
