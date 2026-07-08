<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $hash = Hash::make('password');

        DB::table('users')->insertOrIgnore([
            ['user_id' => 1, 'role_id' => 1, 'username' => 'admin', 'email' => 'admin@library.tz', 'password_hash' => $hash, 'status' => 'active'],
            ['user_id' => 2, 'role_id' => 2, 'username' => 'jbrown', 'email' => 'j.brown@library.tz', 'password_hash' => $hash, 'status' => 'active'],
            ['user_id' => 3, 'role_id' => 3, 'username' => 'akimwaga', 'email' => 'a.kimwaga@library.tz', 'password_hash' => $hash, 'status' => 'active'],
        ]);
    }
}
