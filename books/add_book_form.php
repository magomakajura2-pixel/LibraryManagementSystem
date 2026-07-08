<?php use App\Helpers\{Flash, CSRF}; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-plus-circle me-2"></i>Add Book</h4>
    <div class="card border-0 shadow-sm" style="max-width:700px">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>/books/save_book.php">
                <?= CSRF::field() ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">ISBN <span class="text-danger">*</span></label>
                        <input type="text" name="isbn" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Author <span class="text-danger">*</span></label>
                        <input type="text" name="author" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">— Select —</option>
<?php foreach ($categories as $c): ?>
                            <option value="<?= $c['category_id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
<?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Publisher</label>
                        <input type="text" name="publisher" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Published Year</label>
                        <input type="number" name="published_year" class="form-control" min="1400" max="2100">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Total Copies</label>
                        <input type="number" name="total_copies" class="form-control" value="1" min="1">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Shelf Location</label>
                        <input type="text" name="shelf_location" class="form-control">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-lms"><i class="bi bi-check-lg me-1"></i> Save Book</button>
                    <a href="<?= BASE_URL ?>/books/view_books.php" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
