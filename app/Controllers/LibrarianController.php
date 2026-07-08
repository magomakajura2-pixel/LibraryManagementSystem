<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\LibrarianService;
use App\Validators\LibrarianValidator;
use App\Helpers\{Flash, Redirect};

class LibrarianController
{
    private LibrarianService $svc;
    public function __construct() { $this->svc = new LibrarianService(); }

    public function index(): void {
        $librarians = $this->svc->all();
        $pageTitle  = 'Librarians';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/librarians/view_librarians_page.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function create(): void {
        $pageTitle = 'Add Librarian';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/librarians/add_librarian_form.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function store(): void {
        $v = new LibrarianValidator();
        if (!$v->validate($_POST)) { Redirect::withError('/librarians/add_librarian.php', $v->firstError()); }
        $this->svc->add([
            'user_id'         => (int)$_POST['user_id'],
            'employee_no'     => trim($_POST['employee_no']),
            'first_name'      => trim($_POST['first_name']),
            'last_name'       => trim($_POST['last_name']),
            'email'           => trim($_POST['email'] ?? ''),
            'phone'           => trim($_POST['phone'] ?? ''),
            'privilege_level' => $_POST['privilege_level'] ?? 'assistant',
        ]);
        Redirect::withSuccess('/librarians/view_librarians.php', 'Librarian added.');
    }

    public function edit(): void {
        $id        = (int)($_GET['id'] ?? 0);
        $librarian = $this->svc->find($id);
        if (!$librarian) { Redirect::withError('/librarians/view_librarians.php', 'Librarian not found.'); }
        $pageTitle = 'Edit Librarian';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/librarians/edit_librarian_form.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function update(): void {
        $id = (int)($_POST['librarian_id'] ?? 0);
        $this->svc->edit($id, [
            'employee_no'     => trim($_POST['employee_no']),
            'first_name'      => trim($_POST['first_name']),
            'last_name'       => trim($_POST['last_name']),
            'email'           => trim($_POST['email'] ?? ''),
            'phone'           => trim($_POST['phone'] ?? ''),
            'privilege_level' => $_POST['privilege_level'] ?? 'assistant',
            'status'          => $_POST['status'] ?? 'active',
        ]);
        Redirect::withSuccess('/librarians/view_librarians.php', 'Librarian updated.');
    }

    public function destroy(): void {
        $this->svc->delete((int)($_GET['id'] ?? 0));
        Redirect::withSuccess('/librarians/view_librarians.php', 'Librarian removed.');
    }
}
