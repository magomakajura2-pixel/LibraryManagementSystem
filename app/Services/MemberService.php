<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Member;

class MemberService
{
    private Member $member;
    public function __construct() { $this->member = new Member(); }

    public function all(): array          { return $this->member->all('last_name, first_name'); }
    public function find(int $id): ?array { return $this->member->find($id); }
    public function add(array $data): int { return $this->member->add($data); }
    public function edit(int $id, array $data): int { return $this->member->update($id, $data); }
    public function delete(int $id): int  { return $this->member->delete($id); }
    public function summary(int $id): ?array { return $this->member->summary($id); }
    public function history(int $id): array  { return $this->member->history($id); }
}
