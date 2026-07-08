<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insertOrIgnore([
            ['category_id' => 1, 'name' => 'Computer Science', 'description' => 'Programming, databases, networks'],
            ['category_id' => 2, 'name' => 'Mathematics', 'description' => 'Pure and applied mathematics'],
            ['category_id' => 3, 'name' => 'Fiction', 'description' => 'Novels and short stories'],
            ['category_id' => 4, 'name' => 'History', 'description' => 'World and regional history'],
        ]);
    }
}
