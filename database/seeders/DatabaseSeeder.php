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
        $machine = Machine::query()->create(['name' => 'Machine 1', 'state' => IdleState::class, 'balance' => 0]);

        Product::query()->create([
            'machine_id' => $machine->id,
            'name' => 'coffee',
            'stock' => 10,
            'price' => 1,
        ]);

        Product::query()->create([
            'machine_id' => $machine->id,
            'name' => 'soda',
            'stock' => 15,
            'price' => 2,
        ]);
    }
}
