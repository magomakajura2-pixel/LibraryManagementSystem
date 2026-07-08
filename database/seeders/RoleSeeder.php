<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insertOrIgnore([
            ['role_id' => 1, 'role_name' => 'admin', 'description' => 'Full system access'],
            ['role_id' => 2, 'role_name' => 'librarian', 'description' => 'Manage catalogue, members, borrowing and returns'],
            ['role_id' => 3, 'role_name' => 'assistant', 'description' => 'Front-desk assistant with limited rights'],
        ]);
    }
}
