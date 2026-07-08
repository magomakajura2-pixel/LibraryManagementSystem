<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibrarianSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('librarians')->insertOrIgnore([
            ['user_id' => 2, 'employee_no' => 'EMP-001', 'first_name' => 'James', 'last_name' => 'Brown', 'email' => 'j.brown@library.tz', 'hire_date' => '2026-07-07', 'privilege_level' => 'librarian', 'status' => 'active'],
            ['user_id' => 3, 'employee_no' => 'EMP-002', 'first_name' => 'Amina', 'last_name' => 'Kimwaga', 'email' => 'a.kimwaga@library.tz', 'hire_date' => '2026-07-07', 'privilege_level' => 'assistant', 'status' => 'active'],
        ]);
    }
}
