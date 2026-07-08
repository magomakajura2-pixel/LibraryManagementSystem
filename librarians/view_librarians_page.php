<?php use App\Helpers\{Flash, Session}; ?>
<div class="main-content">
    <?= Flash::render() ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-person-badge me-2"></i>Librarians</h4>
        <a href="<?= BASE_URL ?>/librarians/add_librarian.php" class="btn btn-lms btn-sm"><i class="bi bi-plus-circle me-1"></i> Add</a>
    </div>
    <div class="table-responsive">
        <table class="table table-lms table-hover align-middle">
            <thead><tr><th>#</th><th>Employee No.</th><th>Name</th><th>Email</th><th>Level</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
<?php if (empty($librarians)): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">No librarians found.</td></tr>
<?php else: foreach ($librarians as $i => $l): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= htmlspecialchars($l['employee_no']) ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($l['first_name'].' '.$l['last_name']) ?></td>
                    <td><?= htmlspecialchars($l['email'] ?? '') ?></td>
                    <td><span class="badge <?= $l['privilege_level']==='librarian'?'badge-lms':'bg-secondary' ?>"><?= $l['privilege_level'] ?></span></td>
                    <td><span class="badge <?= $l['status']==='active'?'bg-success':'bg-warning' ?>"><?= $l['status'] ?></span></td>
                    <td>
                        <a href="<?= BASE_URL ?>/librarians/edit_librarian.php?id=<?= $l['librarian_id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <a href="<?= BASE_URL ?>/librarians/delete_librarian.php?id=<?= $l['librarian_id'] ?>" class="btn btn-sm btn-outline-danger" data-confirm="Remove this librarian?"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
<?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
