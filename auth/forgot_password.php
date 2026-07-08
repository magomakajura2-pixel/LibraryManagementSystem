<?php
require_once __DIR__ . '/../bootstrap.php';
use App\Helpers\{Flash, CSRF};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password — <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <h4 class="mb-3" style="color:var(--lms-dark-green)">Reset Password</h4>
        <p class="text-muted mb-4">Enter your email address and an administrator will send you a reset link.</p>
        <?= Flash::render() ?>
        <form method="POST" action="<?= BASE_URL ?>/auth/forgot_password.php">
            <?= CSRF::field() ?>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-lms w-100">Send Reset Request</button>
        </form>
        <a href="<?= BASE_URL ?>/auth/login.php" class="d-block text-center mt-3" style="font-size:.85rem">Back to login</a>
    </div>
</div>
</body>
</html>
