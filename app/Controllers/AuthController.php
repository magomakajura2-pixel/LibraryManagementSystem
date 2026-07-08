<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\AuthService;
use App\Validators\LoginValidator;
use App\Helpers\{Session, Flash, Redirect, CSRF};

class AuthController
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }

    public function showLogin(): void
    {
        Session::start();
        if (Session::isLoggedIn()) {
            Redirect::to('/dashboard/dashboard.php');
        }
        $csrf = CSRF::token();
        require BASE_PATH . '/auth/login_form.php';
    }

    public function authenticate(): void
    {
        Session::start();

        $validator = new LoginValidator();
        if (!$validator->validate($_POST)) {
            Redirect::withError('/auth/login.php', $validator->firstError());
        }

        $user = $this->auth->login(
            trim($_POST['username']),
            $_POST['password']
        );

        if ($user === null) {
            Redirect::withError('/auth/login.php', 'Invalid username or password.');
        }

        Flash::success('Welcome back, ' . htmlspecialchars($user['username']) . '!');
        Redirect::to('/dashboard/dashboard.php');
    }

    public function logout(): void
    {
        Session::start();
        $this->auth->logout();
        Redirect::to('/auth/login.php');
    }
}
