<?php

namespace App\States;

use App\Interfaces\iMachineState;
use App\Models\Machine;
use App\Models\Product;
use App\Models\SelectedProduct;
use Illuminate\Database\UniqueConstraintViolationException;

class CoinInsertedState implements iMachineState
{
    public function insertCoin(Machine $machine, int $amount): string
    {
        throw new \RuntimeException('Coin already inserted.');
    }

    public function selectProduct(Machine $machine, Product $product): string
    {
        if ($product->stock === 0) {
            throw new \RuntimeException('Product unavailable or out of stock.');
        }

        if ($machine->balance < $product->price) {
            throw new \RuntimeException('Insufficient balance.');
        }

        try {
            SelectedProduct::query()->create([
                'machine_id' => $machine->id,
                'product_id' => $product->id,
            ]);

            Machine::updateState($machine, DispensingState::class);

            return "Dispensing {$product->name}...";
        } catch (UniqueConstraintViolationException $e) {
            throw new \RuntimeException('Product selected before.');
        } catch (\Throwable $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function dispense(Machine $machine): string
    {
        throw new \RuntimeException('Please select a product first.');
    }
}
