<?php use App\Helpers\Flash; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <h4 class="fw-bold mb-4"><i class="bi bi-bar-chart me-2"></i>Most Borrowed Books</h4>
    <div class="table-responsive">
        <table class="table table-lms table-hover align-middle">
            <thead><tr><th>Rank</th><th>Title</th><th>Author</th><th>Times Borrowed</th></tr></thead>
            <tbody>
<?php foreach ($books as $i => $b): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($b['title']) ?></td>
                    <td><?= htmlspecialchars($b['author']) ?></td>
                    <td><span class="badge bg-primary"><?= $b['times_borrowed'] ?></span></td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
