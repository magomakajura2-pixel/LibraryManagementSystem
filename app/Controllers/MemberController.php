<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\MemberService;
use App\Validators\MemberValidator;
use App\Helpers\{Flash, Redirect};

class MemberController
{
    private MemberService $svc;
    public function __construct() { $this->svc = new MemberService(); }

    public function index(): void {
        $members   = $this->svc->all();
        $pageTitle = 'Members';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/members/view_members_page.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function create(): void {
        $pageTitle = 'Add Member';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/members/add_member_form.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function store(): void {
        $v = new MemberValidator();
        if (!$v->validate($_POST)) { Redirect::withError('/members/add_member.php', $v->firstError()); }
        $this->svc->add([
            'membership_no' => trim($_POST['membership_no']),
            'first_name'    => trim($_POST['first_name']),
            'last_name'     => trim($_POST['last_name']),
            'email'         => trim($_POST['email'] ?? ''),
            'phone'         => trim($_POST['phone'] ?? ''),
            'address'       => trim($_POST['address'] ?? ''),
        ]);
        Redirect::withSuccess('/members/view_members.php', 'Member registered.');
    }

    public function edit(): void {
        $id     = (int)($_GET['id'] ?? 0);
        $member = $this->svc->find($id);
        if (!$member) { Redirect::withError('/members/view_members.php', 'Member not found.'); }
        $pageTitle = 'Edit Member';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/members/edit_member_form.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function update(): void {
        $id = (int)($_POST['member_id'] ?? 0);
        $v  = new MemberValidator();
        if (!$v->validate($_POST)) { Redirect::withError("/members/edit_member.php?id={$id}", $v->firstError()); }
        $this->svc->edit($id, [
            'membership_no' => trim($_POST['membership_no']),
            'first_name'    => trim($_POST['first_name']),
            'last_name'     => trim($_POST['last_name']),
            'email'         => trim($_POST['email'] ?? ''),
            'phone'         => trim($_POST['phone'] ?? ''),
            'address'       => trim($_POST['address'] ?? ''),
            'status'        => $_POST['status'] ?? 'active',
        ]);
        Redirect::withSuccess('/members/view_members.php', 'Member updated.');
    }

    public function destroy(): void {
        $id = (int)($_GET['id'] ?? 0);
        $this->svc->delete($id);
        Redirect::withSuccess('/members/view_members.php', 'Member removed.');
    }

    public function profile(): void {
        $id      = (int)($_GET['id'] ?? 0);
        $member  = $this->svc->find($id);
        if (!$member) { Redirect::withError('/members/view_members.php', 'Member not found.'); }
        $summary = $this->svc->summary($id);
        $pageTitle = 'Member Profile';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/members/member_profile_page.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function history(): void {
        $id      = (int)($_GET['id'] ?? 0);
        $member  = $this->svc->find($id);
        if (!$member) { Redirect::withError('/members/view_members.php', 'Member not found.'); }
        $history = $this->svc->history($id);
        $pageTitle = 'Borrowing History';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/members/member_history_page.php';
        require BASE_PATH . '/includes/footer.php';
    }
}
