<?php
require_once __DIR__ . '/bootstrap.php';

use App\Helpers\{Session, Redirect};

if (Session::isLoggedIn()) {
    Redirect::to('/dashboard/dashboard.php');
} else {
    Redirect::to('/auth/login.php');
}
