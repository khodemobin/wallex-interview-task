<?php

namespace App\States;

use App\Interfaces\iMachineState;
use App\Models\Machine;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DispensingState implements iMachineState
{
    public function insertCoin(Machine $machine, int $amount): string
    {
        throw new \RuntimeException('Dispensing in progress. Please wait.');
    }

    public function selectProduct(Machine $machine, Product $product): string
    {
        throw new \RuntimeException('Dispensing in progress. Please wait.');
    }

    public function dispense(Machine $machine): string
    {
        $selectedProduct = $machine->selectedProduct;
        if (! $selectedProduct) {
            throw new \RuntimeException('No product selected.');
        }

        if ($selectedProduct->product->stock === 0) {
            throw new \RuntimeException('Product unavailable or out of stock.');
        }

        DB::transaction(static function () use ($machine, $selectedProduct) {
            $selectedProduct->product()->decrement('stock');
            $machine->state = IdleState::class;
            $machine->balance -= $selectedProduct->product->price;
            $machine->save();
            $machine->selectedProduct->delete();
        });

        return "Dispensed {$selectedProduct->product->name}. Enjoy!";
    }
}
