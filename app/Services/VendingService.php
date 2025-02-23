<?php

namespace App\Services;

use App\Models\Machine;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

readonly class VendingService
{
    public function machines(): Collection
    {
        return Machine::query()
            ->with('products')
            ->latest()
            ->get();
    }

    public function handleInsertCoin(Machine $machine, int $amount): string
    {
        $result = (new $machine->state)->insertCoin($machine, $amount);
        Log::info('coin_inserted');

        return $result;
    }

    /**
     * @throws \Exception
     */
    public function handleSelectProduct(Machine $machine, Product $product): string
    {
        $result = (new $machine->state)->selectProduct($machine, $product);
        Log::info('product_selected'.$product->name);

        return $result;
    }

    /**
     * @throws \Exception
     */
    public function handleDispensing(Machine $machine): string
    {
        $result = (new $machine->state)->dispense($machine);
        Log::info('product_dispensed');

        return $result;
    }
}
