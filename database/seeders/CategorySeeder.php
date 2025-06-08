<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {

        $categories = [
            [
                'name' => 'طاولة طعام الحب',
                'slug' => 'love-table',
                'image' => 'img/love-table.png',
                'description' => 'قصص ومقالات تنبض بالحب والعلاقات الإنسانية.'
            ],
            [
                'name' => 'زهرة الصحراء',
                'slug' => 'desert-flower',
                'image' => 'img/desert-flower.png',
                'description' => 'قوة البقاء والأمل وسط أقسى الظروف عبر قصص ملهمة.'
            ],
            [
                'name' => 'التوعية الصحية',
                'slug' => 'health-awareness',
                'image' => 'img/health-awareness.png',
                'description' => 'مقالات ونصائح للحفاظ على الصحة والوقاية من الأمراض'
            ],
            [
                'name' => 'أصوات الحرب',
                'slug' => 'voices-of-war',
                'image' => 'img/voices-of-war.png',
                'description' => 'حكايات من قلب الحروب والصراعات الإنسانية وتأثيرها.'
            ],
            [
                'name' => 'منصة الذكريات',
                'slug' => 'memories',
                'image' => 'img/memories.png',
                'description' => 'تخليد اللحظات الجميلة والذكريات العزيزة في كلمات وصور.'
            ],
            [
                'name' => 'نصائح الطقس',
                'slug' => 'weather-tips',
                'image' => 'img/weather-tips.png',
                'description' => 'استعد لكل الفصول مع نصائح عملية لمواجهة تغيرات الطقس.'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
