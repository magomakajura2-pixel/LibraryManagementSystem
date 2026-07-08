<?php use App\Helpers\Flash; $m = $member; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-clock-history me-2"></i>Borrowing History — <?= htmlspecialchars($m['first_name'].' '.$m['last_name']) ?></h4>
    <div class="table-responsive">
        <table class="table table-lms table-hover align-middle">
            <thead><tr><th>#</th><th>Title</th><th>Borrowed</th><th>Due</th><th>Status</th></tr></thead>
            <tbody>
<?php if (empty($history)): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">No borrowing history.</td></tr>
<?php else: foreach ($history as $i => $h): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= htmlspecialchars($h['title']) ?></td>
                    <td><?= date(DATE_DISPLAY, strtotime($h['borrow_date'])) ?></td>
                    <td><?= date(DATE_DISPLAY, strtotime($h['due_date'])) ?></td>
                    <td>
                        <span class="badge <?php
                            echo match($h['status']) {
                                'returned' => 'bg-success',
                                'overdue'  => 'bg-danger',
                                'lost'     => 'bg-dark',
                                default    => 'bg-primary',
                            };
                        ?>"><?= $h['status'] ?></span>
                    </td>
                </tr>
<?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <a href="<?= BASE_URL ?>/members/view_members.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>
