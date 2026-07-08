<?php use App\Helpers\Flash; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-stack me-2"></i>Book Availability</h4>
    <div class="table-responsive">
        <table class="table table-lms table-hover align-middle">
            <thead><tr><th>Title</th><th>Author</th><th>Category</th><th>Total</th><th>Available</th><th>On Loan</th><th>Status</th></tr></thead>
            <tbody>
<?php foreach ($books as $b): ?>
                <tr>
                    <td class="fw-semibold"><?= htmlspecialchars($b['title']) ?></td>
                    <td><?= htmlspecialchars($b['author']) ?></td>
                    <td><?= htmlspecialchars($b['category'] ?? '—') ?></td>
                    <td><?= $b['total_copies'] ?></td>
                    <td><span class="badge <?= $b['available_copies'] > 0 ? 'bg-success' : 'bg-danger' ?>"><?= $b['available_copies'] ?></span></td>
                    <td><?= $b['copies_on_loan'] ?></td>
                    <td><?= htmlspecialchars($b['status']) ?></td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
