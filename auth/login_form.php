<?php use App\Helpers\{Flash, CSRF}; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <div class="text-center mb-4">
            <i class="bi bi-book" style="font-size:2.5rem;color:var(--lms-dark-green)"></i>
            <h2 class="mt-2"><?= APP_NAME ?></h2>
            <p class="text-muted">Sign in to continue</p>
        </div>
        <?= Flash::render() ?>
        <form method="POST" action="<?= BASE_URL ?>/auth/authenticate.php" autocomplete="off">
            <?= CSRF::field() ?>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Enter username" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-lms w-100 mt-2">
                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
            </button>
        </form>
        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/auth/forgot_password.php" class="text-muted" style="font-size:.85rem">Forgot password?</a>
        </div>
    </div>
</div>
</body>
</html>
