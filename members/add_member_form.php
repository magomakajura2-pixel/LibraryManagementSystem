<?php use App\Helpers\{Flash, CSRF}; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-person-plus me-2"></i>Register Member</h4>
    <div class="card border-0 shadow-sm" style="max-width:650px">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>/members/save_member.php">
                <?= CSRF::field() ?>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Membership No. <span class="text-danger">*</span></label>
                        <input type="text" name="membership_no" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"></div>
                    <div class="col-12"><label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-lms"><i class="bi bi-check-lg me-1"></i> Register</button>
                    <a href="<?= BASE_URL ?>/members/view_members.php" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
