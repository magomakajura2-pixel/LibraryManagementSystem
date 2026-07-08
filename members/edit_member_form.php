<?php use App\Helpers\{Flash, CSRF}; $m = $member; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-pencil me-2"></i>Edit Member</h4>
    <div class="card border-0 shadow-sm" style="max-width:650px">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>/members/update_member.php">
                <?= CSRF::field() ?>
                <input type="hidden" name="member_id" value="<?= $m['member_id'] ?>">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Membership No.</label>
                        <input type="text" name="membership_no" class="form-control" value="<?= htmlspecialchars($m['membership_no']) ?>" required></div>
                    <div class="col-md-6"><label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($m['first_name']) ?>" required></div>
                    <div class="col-md-6"><label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($m['last_name']) ?>" required></div>
                    <div class="col-md-6"><label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($m['email'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($m['phone'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= $m['status']==='active'?'selected':'' ?>>Active</option>
                            <option value="suspended" <?= $m['status']==='suspended'?'selected':'' ?>>Suspended</option>
                            <option value="expired" <?= $m['status']==='expired'?'selected':'' ?>>Expired</option>
                        </select></div>
                    <div class="col-12"><label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($m['address'] ?? '') ?></textarea></div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-lms"><i class="bi bi-check-lg me-1"></i> Update</button>
                    <a href="<?= BASE_URL ?>/members/view_members.php" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
