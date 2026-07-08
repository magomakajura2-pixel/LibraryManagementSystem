<?php use App\Helpers\{Flash, CSRF}; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-box-arrow-up-right me-2"></i>Issue Book</h4>
    <div class="card border-0 shadow-sm" style="max-width:650px">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>/borrowings/save_borrowing.php">
                <?= CSRF::field() ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Book <span class="text-danger">*</span></label>
                        <select name="book_id" class="form-select" required>
                            <option value="">— Select book —</option>
<?php foreach ($books as $b): if(($b['available_copies'] ?? 0) > 0): ?>
                            <option value="<?= $b['book_id'] ?>"><?= htmlspecialchars($b['title']) ?> (<?= $b['available_copies'] ?> avail.)</option>
<?php endif; endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Member <span class="text-danger">*</span></label>
                        <select name="member_id" class="form-select" required>
                            <option value="">— Select member —</option>
<?php foreach ($members as $m): ?>
                            <option value="<?= $m['member_id'] ?>"><?= htmlspecialchars($m['first_name'].' '.$m['last_name']) ?> (<?= $m['membership_no'] ?>)</option>
<?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Issuing Librarian</label>
                        <select name="librarian_id" class="form-select">
                            <option value="">— Select —</option>
<?php foreach ($librarians as $lb): ?>
                            <option value="<?= $lb['librarian_id'] ?>"><?= htmlspecialchars($lb['first_name'].' '.$lb['last_name']) ?></option>
<?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Loan Period (days)</label>
                        <input type="number" name="loan_days" class="form-control" value="<?= DEFAULT_LOAN_DAYS ?>" min="1" max="90">
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-lms"><i class="bi bi-check-lg me-1"></i> Issue</button>
                    <a href="<?= BASE_URL ?>/borrowings/view_borrowings.php" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
