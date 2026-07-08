<?php use App\Helpers\Flash; $m = $member; $s = $summary; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-person-circle me-2"></i>Member Profile</h4>
    <div class="row g-4">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold"><?= htmlspecialchars($m['first_name'].' '.$m['last_name']) ?></h5>
                    <p class="text-muted mb-2"><?= htmlspecialchars($m['membership_no']) ?></p>
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td class="text-muted">Email</td><td><?= htmlspecialchars($m['email'] ?? '—') ?></td></tr>
                        <tr><td class="text-muted">Phone</td><td><?= htmlspecialchars($m['phone'] ?? '—') ?></td></tr>
                        <tr><td class="text-muted">Address</td><td><?= htmlspecialchars($m['address'] ?? '—') ?></td></tr>
                        <tr><td class="text-muted">Joined</td><td><?= date(DATE_DISPLAY, strtotime($m['join_date'])) ?></td></tr>
                        <tr><td class="text-muted">Status</td><td><span class="badge <?= $m['status']==='active'?'bg-success':'bg-warning' ?>"><?= $m['status'] ?></span></td></tr>
                    </table>
                </div>
            </div>
        </div>
<?php if ($s): ?>
        <div class="col-md-7">
            <div class="row g-3">
                <div class="col-4"><div class="card border-0 shadow-sm text-center p-3"><div class="stat-value"><?= $s['total_borrowings'] ?></div><div class="stat-label">Total Loans</div></div></div>
                <div class="col-4"><div class="card border-0 shadow-sm text-center p-3"><div class="stat-value"><?= $s['active_loans'] ?></div><div class="stat-label">Active</div></div></div>
                <div class="col-4"><div class="card border-0 shadow-sm text-center p-3"><div class="stat-value text-danger"><?= number_format((float)$s['outstanding_fines']) ?></div><div class="stat-label">Fines (TZS)</div></div></div>
            </div>
            <a href="<?= BASE_URL ?>/members/member_history.php?id=<?= $m['member_id'] ?>" class="btn btn-outline-secondary btn-sm mt-3"><i class="bi bi-clock-history me-1"></i> View Full History</a>
        </div>
<?php endif; ?>
    </div>
</div>
