<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // Tambahkan ini

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Makanan', 'Minuman', 'Snack'];
        
        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }
    }
}