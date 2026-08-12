<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product; // Tambahkan ini

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'category_id' => 1,
                'sku' => 'FOOD-001',
                'name' => 'Nasi Goreng Spesial',
                'price' => 25000,
                'stock' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'sku' => 'BEV-001',
                'name' => 'Es Kopi Susu Gula Aren',
                'price' => 18000,
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'sku' => 'SNK-001',
                'name' => 'Kentang Goreng',
                'price' => 15000,
                'stock' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}