<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('system_settings')->insertOrIgnore([
            ['setting_key' => 'fine_per_day', 'setting_value' => '500', 'description' => 'Overdue fine per day (TZS)'],
            ['setting_key' => 'library_name', 'setting_value' => 'MAGA Community Library', 'description' => 'Display name'],
            ['setting_key' => 'loan_period', 'setting_value' => '14', 'description' => 'Default loan period in days'],
            ['setting_key' => 'max_books', 'setting_value' => '5', 'description' => 'Maximum concurrent loans per member'],
        ]);
    }
}
