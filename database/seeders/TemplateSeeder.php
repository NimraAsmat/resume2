<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            [
                'name' => 'Professional Blue',
                'category' => 'Professional',
                'image_path' => '/images/templates/professional-blue.jpg',
                'view_name' => 'template1',
                'description' => 'Clean and professional design with blue accents, perfect for corporate environments.',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Modern Black',
                'category' => 'Modern',
                'image_path' => '/images/templates/modern-black.jpg',
                'view_name' => 'template2',
                'description' => 'Contemporary design with dark accents and clean lines for modern industries.',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Creative Green',
                'category' => 'Creative',
                'image_path' => '/images/templates/creative-green.jpg',
                'view_name' => 'template3',
                'description' => 'Fresh and creative design with green theme for design and marketing fields.',
                'is_active' => true,
                'sort_order' => 3
            ]
        ];

        foreach ($templates as $template) {
            Template::create($template);
        }
    }
}