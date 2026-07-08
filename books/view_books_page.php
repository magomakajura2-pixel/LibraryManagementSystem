<?php use App\Helpers\{Flash, CSRF, Session}; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-book me-2"></i>Books</h4>
<?php if (in_array(Session::role(), ['admin','librarian'])): ?>
        <a href="<?= BASE_URL ?>/books/add_book.php" class="btn btn-lms btn-sm"><i class="bi bi-plus-circle me-1"></i> Add Book</a>
<?php endif; ?>
    </div>

    <!-- Search -->
    <form method="GET" action="<?= BASE_URL ?>/books/view_books.php" class="mb-3">
        <div class="input-group" style="max-width:400px">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Search title, author or ISBN…"
                   value="<?= htmlspecialchars($search ?? '') ?>">
            <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-lms table-hover align-middle">
            <thead><tr>
                <th>#</th><th>ISBN</th><th>Title</th><th>Author</th>
                <th>Available</th><th>Status</th><th>Actions</th>
            </tr></thead>
            <tbody>
<?php if (empty($books)): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">No books found.</td></tr>
<?php else: foreach ($books as $i => $b): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><small><?= htmlspecialchars($b['isbn']) ?></small></td>
                    <td class="fw-semibold"><?= htmlspecialchars($b['title']) ?></td>
                    <td><?= htmlspecialchars($b['author']) ?></td>
                    <td>
                        <span class="badge <?= ($b['available_copies'] ?? 0) > 0 ? 'bg-success' : 'bg-danger' ?>">
                            <?= $b['available_copies'] ?? 0 ?> / <?= $b['total_copies'] ?? 0 ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($b['status']) ?></td>
                    <td>
<?php if (in_array(Session::role(), ['admin','librarian'])): ?>
                        <a href="<?= BASE_URL ?>/books/edit_book.php?id=<?= $b['book_id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i></a>
                        <a href="<?= BASE_URL ?>/books/delete_book.php?id=<?= $b['book_id'] ?>" class="btn btn-sm btn-outline-danger"
                           data-confirm="Delete this book?" title="Delete"><i class="bi bi-trash"></i></a>
<?php endif; ?>
                    </td>
                </tr>
<?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
