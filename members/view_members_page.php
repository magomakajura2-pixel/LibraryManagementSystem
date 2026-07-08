<?php use App\Helpers\{Flash, Session}; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-people me-2"></i>Members</h4>
        <a href="<?= BASE_URL ?>/members/add_member.php" class="btn btn-lms btn-sm"><i class="bi bi-person-plus me-1"></i> Add Member</a>
    </div>
    <div class="table-responsive">
        <table class="table table-lms table-hover align-middle">
            <thead><tr><th>#</th><th>No.</th><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
<?php if (empty($members)): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">No members found.</td></tr>
<?php else: foreach ($members as $i => $m): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= htmlspecialchars($m['membership_no']) ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?></td>
                    <td><?= htmlspecialchars($m['email'] ?? '') ?></td>
                    <td><?= htmlspecialchars($m['phone'] ?? '') ?></td>
                    <td><span class="badge <?= $m['status']==='active' ? 'bg-success' : 'bg-warning' ?>"><?= $m['status'] ?></span></td>
                    <td>
                        <a href="<?= BASE_URL ?>/members/member_profile.php?id=<?= $m['member_id'] ?>" class="btn btn-sm btn-outline-info" title="Profile"><i class="bi bi-eye"></i></a>
                        <a href="<?= BASE_URL ?>/members/member_history.php?id=<?= $m['member_id'] ?>" class="btn btn-sm btn-outline-secondary" title="History"><i class="bi bi-clock-history"></i></a>
                        <a href="<?= BASE_URL ?>/members/edit_member.php?id=<?= $m['member_id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                        <a href="<?= BASE_URL ?>/members/delete_member.php?id=<?= $m['member_id'] ?>" class="btn btn-sm btn-outline-danger" data-confirm="Delete this member?" title="Delete"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
<?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
