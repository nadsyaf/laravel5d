<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Nail Art', 'slug' => 'nail-art'],
            ['name' => 'Lash Extension', 'slug' => 'lash-extension'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $category['slug']],
                ['name' => $category['name']]
            );
        }
    }
}
