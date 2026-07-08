<?php use App\Helpers\{Flash, CSRF}; $l = $librarian; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-pencil me-2"></i>Edit Librarian</h4>
    <div class="card border-0 shadow-sm" style="max-width:650px">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>/librarians/update_librarian.php">
                <?= CSRF::field() ?>
                <input type="hidden" name="librarian_id" value="<?= $l['librarian_id'] ?>">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Employee No.</label>
                        <input type="text" name="employee_no" class="form-control" value="<?= htmlspecialchars($l['employee_no']) ?>" required></div>
                    <div class="col-md-6"><label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($l['first_name']) ?>" required></div>
                    <div class="col-md-6"><label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($l['last_name']) ?>" required></div>
                    <div class="col-md-6"><label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($l['email'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($l['phone'] ?? '') ?>"></div>
                    <div class="col-md-3"><label class="form-label">Level</label>
                        <select name="privilege_level" class="form-select">
                            <option value="assistant" <?= $l['privilege_level']==='assistant'?'selected':'' ?>>Assistant</option>
                            <option value="librarian" <?= $l['privilege_level']==='librarian'?'selected':'' ?>>Librarian</option>
                        </select></div>
                    <div class="col-md-3"><label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= $l['status']==='active'?'selected':'' ?>>Active</option>
                            <option value="inactive" <?= $l['status']==='inactive'?'selected':'' ?>>Inactive</option>
                        </select></div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-lms"><i class="bi bi-check-lg me-1"></i> Update</button>
                    <a href="<?= BASE_URL ?>/librarians/view_librarians.php" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
