<?php use App\Helpers\Session; ?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-lms fixed-top">
    <div class="container-fluid">
        <button class="btn btn-sm d-lg-none me-2" id="sidebarToggle" style="color:#fff;border:1px solid rgba(255,255,255,.3)">
            <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/dashboard/dashboard.php">
            <i class="bi bi-book me-1"></i> <?= APP_NAME ?>
        </a>
        <div class="d-flex align-items-center ms-auto">
            <span class="text-light me-3 d-none d-md-inline" style="font-size:.85rem">
                <i class="bi bi-person-circle me-1"></i>
                <?= htmlspecialchars(Session::get('username', '')) ?>
                <span class="badge bg-light text-dark ms-1"><?= htmlspecialchars(Session::role() ?? '') ?></span>
            </span>
            <a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>
<!-- spacer for fixed navbar -->
<div style="height:56px"></div>
