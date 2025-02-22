<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Product::create(['name' => 'coffee', 'stock' => 10, 'price' => 2.00]);
        Product::create(['name' => 'soda', 'stock' => 15, 'price' => 1.50]);
    }
}
