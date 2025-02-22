<?php

namespace Database\Seeders;

use App\Models\Machine;
use App\Models\Product;
use App\States\IdleState;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Machine::query()->create(['name' => 'Machine 1', 'state' => IdleState::class]);

        Product::query()->create(['name' => 'coffee', 'stock' => 10]);
        Product::query()->create(['name' => 'soda', 'stock' => 15]);
    }
}
