<?php use App\Helpers\Flash; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Overdue Books</h4>
    <div class="table-responsive">
        <table class="table table-lms table-hover align-middle">
            <thead><tr><th>Loan #</th><th>Book</th><th>Member</th><th>Borrowed</th><th>Due</th><th>Days Overdue</th></tr></thead>
            <tbody>
<?php if (empty($books)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No overdue books — all clear!</td></tr>
<?php else: foreach ($books as $b): ?>
                <tr>
                    <td><?= $b['borrowing_id'] ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($b['title']) ?></td>
                    <td><?= htmlspecialchars($b['member_name']) ?></td>
                    <td><?= date(DATE_DISPLAY, strtotime($b['borrow_date'])) ?></td>
                    <td><?= date(DATE_DISPLAY, strtotime($b['due_date'])) ?></td>
                    <td><span class="badge bg-danger"><?= $b['days_overdue'] ?> day(s)</span></td>
                </tr>
<?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
