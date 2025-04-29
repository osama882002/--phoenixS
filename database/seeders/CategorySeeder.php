<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'طاولة طعام الحب', 'slug' => 'love-table'],
            ['name' => 'زهرة الصحراء', 'slug' => 'desert-flower'],
            ['name' => 'التوعية الصحية', 'slug' => 'health-awareness'],
            ['name' => 'أصوات الحرب', 'slug' => 'voices-of-war'],
            ['name' => 'منصة الذكريات', 'slug' => 'memories'],
            ['name' => 'نصائح الطقس', 'slug' => 'weather-tips'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
