<?php
$pageTitle = 'Return Book';
require_once __DIR__.'/../app/Helpers/Bootstrap.php';
use App\Middleware\Auth; use App\Helpers\{CSRF,Flash,Redirect}; use App\Models\Borrowing; use App\Config\Database;
Auth::requireRole(['admin','librarian','assistant']);

$borrowingId = (int)($_GET['id'] ?? 0);
$loan = null;
if ($borrowingId) {
    $db = Database::connection();
    $stmt = $db->prepare(
        "SELECT br.*, b.title, CONCAT(m.first_name,' ',m.last_name) AS member_name
           FROM borrowings br
           JOIN books b ON b.book_id = br.book_id
           JOIN members m ON m.member_id = br.member_id
          WHERE br.borrowing_id = :id AND br.status IN ('borrowed','overdue')"
    );
    $stmt->execute([':id' => $borrowingId]);
    $loan = $stmt->fetch();
}

// Fetch active loans for the dropdown when no ID is pre-selected.
$activeLoans = Database::connection()->query(
    "SELECT br.borrowing_id, b.title, CONCAT(m.first_name,' ',m.last_name) AS member_name
       FROM borrowings br
       JOIN books b ON b.book_id = br.book_id
       JOIN members m ON m.member_id = br.member_id
      WHERE br.status IN ('borrowed','overdue')
      ORDER BY br.due_date"
)->fetchAll();

$staff = Database::connection()->query(
    "SELECT librarian_id, CONCAT(first_name,' ',last_name) AS name FROM librarians WHERE status='active' ORDER BY last_name"
)->fetchAll();

include __DIR__.'/../includes/header.php'; include __DIR__.'/../includes/navbar.php'; include __DIR__.'/../includes/sidebar.php';
?>
<div class="page-wrapper"><main class="main-content">
    <h4 class="fw-bold mb-4"><i class="bi bi-arrow-left-circle me-2"></i>Return Book</h4>
    <?= Flash::render() ?>

    <?php if ($loan): ?>
    <div class="alert alert-info">
        Returning <strong><?= htmlspecialchars($loan['title']) ?></strong>
        borrowed by <strong><?= htmlspecialchars($loan['member_name']) ?></strong>
        (due <?= $loan['due_date'] ?>).
    </div>
    <?php endif; ?>

    <div class="card"><div class="card-body">
        <form action="save_return.php" method="POST">
            <?= CSRF::field() ?>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Loan <span class="text-danger">*</span></label>
                    <select class="form-select" name="borrowing_id" required>
                        <?php if ($loan): ?>
                            <option value="<?= $loan['borrowing_id'] ?>" selected>#<?= $loan['borrowing_id'] ?> — <?= htmlspecialchars($loan['title']) ?> (<?= htmlspecialchars($loan['member_name']) ?>)</option>
                        <?php else: ?>
                            <option value="">— Select loan —</option>
                            <?php foreach ($activeLoans as $al): ?>
                                <option value="<?= $al['borrowing_id'] ?>">#<?= $al['borrowing_id'] ?> — <?= htmlspecialchars($al['title']) ?> (<?= htmlspecialchars($al['member_name']) ?>)</option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3"><label class="form-label">Condition</label>
                    <select class="form-select" name="condition">
                        <option value="good">Good</option><option value="damaged">Damaged</option><option value="lost">Lost</option>
                    </select>
                </div>
                <div class="col-md-3"><label class="form-label">Received By</label>
                    <select class="form-select" name="received_by">
                        <option value="">— Select —</option>
                        <?php foreach ($staff as $s): ?><option value="<?= $s['librarian_id'] ?>"><?= htmlspecialchars($s['name']) ?></option><?php endforeach; ?>
                    </select>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Record Return</button>
            <a href="<?= BASE_URL ?>borrowings/view_borrowings.php" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div></div>
<?php include __DIR__.'/../includes/footer.php'; ?>
