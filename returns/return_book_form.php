<?php use App\Helpers\{Flash, CSRF}; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-box-arrow-in-down-left me-2"></i>Return Book</h4>
    <div class="card border-0 shadow-sm" style="max-width:600px">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>/returns/save_return.php">
                <?= CSRF::field() ?>
                <div class="mb-3">
                    <label class="form-label">Select Loan <span class="text-danger">*</span></label>
                    <select name="borrowing_id" class="form-select" required>
                        <option value="">— Select active loan —</option>
<?php foreach ($loans as $l): ?>
                        <option value="<?= $l['borrowing_id'] ?>">
                            #<?= $l['borrowing_id'] ?> — <?= htmlspecialchars($l['title']) ?> → <?= htmlspecialchars($l['member']) ?> (due <?= date(DATE_DISPLAY, strtotime($l['due_date'])) ?>)
                        </option>
<?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Book Condition</label>
                    <select name="book_condition" class="form-select">
                        <option value="good">Good</option>
                        <option value="damaged">Damaged</option>
                        <option value="lost">Lost</option>
                    </select>
                </div>
                <button class="btn btn-gold"><i class="bi bi-check-lg me-1"></i> Record Return</button>
            </form>
        </div>
    </div>
</div>
