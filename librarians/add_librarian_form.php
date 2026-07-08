<?php use App\Helpers\{Flash, CSRF}; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-person-plus me-2"></i>Add Librarian</h4>
    <div class="card border-0 shadow-sm" style="max-width:650px">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>/librarians/save_librarian.php">
                <?= CSRF::field() ?>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Employee No. <span class="text-danger">*</span></label>
                        <input type="text" name="employee_no" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">User ID <span class="text-danger">*</span></label>
                        <input type="number" name="user_id" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Privilege Level</label>
                        <select name="privilege_level" class="form-select">
                            <option value="assistant">Assistant</option>
                            <option value="librarian">Librarian</option>
                        </select></div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-lms"><i class="bi bi-check-lg me-1"></i> Save</button>
                    <a href="<?= BASE_URL ?>/librarians/view_librarians.php" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
