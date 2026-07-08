<?php
use App\Helpers\Session;
$_role    = Session::role();
$_uri     = $_SERVER['REQUEST_URI'] ?? '';
$_active  = function(string $path) use ($_uri): string {
    return str_contains($_uri, BASE_URL . $path) ? 'active' : '';
};
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-heading">Main</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= $_active('/dashboard') ?>" href="<?= BASE_URL ?>/dashboard/dashboard.php">
                <i class="bi bi-speedometer2"></i> Dashboard</a>
        </li>
    </ul>

    <div class="sidebar-heading">Catalogue</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= $_active('/books/view') ?>" href="<?= BASE_URL ?>/books/view_books.php">
                <i class="bi bi-book"></i> Books</a>
        </li>
<?php if (in_array($_role, ['admin','librarian'])): ?>
        <li class="nav-item">
            <a class="nav-link <?= $_active('/books/add') ?>" href="<?= BASE_URL ?>/books/add_book.php">
                <i class="bi bi-plus-circle"></i> Add Book</a>
        </li>
<?php endif; ?>
    </ul>

<?php if (in_array($_role, ['admin','librarian'])): ?>
    <div class="sidebar-heading">People</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= $_active('/members/view') ?>" href="<?= BASE_URL ?>/members/view_members.php">
                <i class="bi bi-people"></i> Members</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $_active('/members/add') ?>" href="<?= BASE_URL ?>/members/add_member.php">
                <i class="bi bi-person-plus"></i> Add Member</a>
        </li>
<?php if ($_role === 'admin'): ?>
        <li class="nav-item">
            <a class="nav-link <?= $_active('/librarians') ?>" href="<?= BASE_URL ?>/librarians/view_librarians.php">
                <i class="bi bi-person-badge"></i> Librarians</a>
        </li>
<?php endif; ?>
    </ul>
<?php endif; ?>

    <div class="sidebar-heading">Circulation</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= $_active('/borrowings') ?>" href="<?= BASE_URL ?>/borrowings/view_borrowings.php">
                <i class="bi bi-arrow-right-circle"></i> Active Loans</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $_active('/borrowings/issue') ?>" href="<?= BASE_URL ?>/borrowings/issue_book.php">
                <i class="bi bi-box-arrow-up-right"></i> Issue Book</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $_active('/returns') ?>" href="<?= BASE_URL ?>/returns/return_book.php">
                <i class="bi bi-box-arrow-in-down-left"></i> Return Book</a>
        </li>
    </ul>

<?php if (in_array($_role, ['admin','librarian'])): ?>
    <div class="sidebar-heading">Reports</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= $_active('overdue') ?>" href="<?= BASE_URL ?>/reports/overdue.php">
                <i class="bi bi-exclamation-triangle"></i> Overdue Books</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $_active('most_borrowed') ?>" href="<?= BASE_URL ?>/reports/most_borrowed.php">
                <i class="bi bi-bar-chart"></i> Most Borrowed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $_active('availability') ?>" href="<?= BASE_URL ?>/reports/availability.php">
                <i class="bi bi-stack"></i> Availability</a>
        </li>
    </ul>
<?php endif; ?>
</aside>
