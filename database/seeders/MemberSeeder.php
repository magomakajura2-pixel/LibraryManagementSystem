<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('members')->insertOrIgnore([
            ['membership_no' => 'MEM-0001', 'first_name' => 'Grace', 'last_name' => 'Mushi', 'email' => 'grace.mushi@example.com', 'phone' => '+255700000001', 'join_date' => '2025-01-15', 'status' => 'active'],
            ['membership_no' => 'MEM-0002', 'first_name' => 'Daniel', 'last_name' => 'Owino', 'email' => 'daniel.owino@example.com', 'phone' => '+255700000002', 'join_date' => '2025-02-10', 'status' => 'active'],
            ['membership_no' => 'MEM-0003', 'first_name' => 'Fatuma', 'last_name' => 'Hassan', 'email' => 'fatuma.h@example.com', 'phone' => '+255700000003', 'join_date' => '2025-03-05', 'status' => 'active'],
            ['membership_no' => 'MEM-0004', 'first_name' => 'Peter', 'last_name' => 'Nyerere', 'email' => 'peter.n@example.com', 'phone' => '+255700000004', 'join_date' => '2025-04-20', 'status' => 'active'],
        ]);
    }
}
