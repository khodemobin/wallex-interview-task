<?php

namespace Tests\Unit;

use App\Models\Machine;
use App\Models\Product;
use App\Services\VendingService;
use App\States\CoinInsertedState;
use App\States\DispensingState;
use Tests\TestCase;

class ProductSelectionTest extends TestCase
{
    public function test_product_selection_coffee(): void
    {
        $vendingMachine = Machine::first();
        $service = new VendingService;
        $coffee = Product::query()->where('name', 'coffee')->first();

        $service->handleInsertCoin($vendingMachine, 1);
        $service->handleSelectProduct($vendingMachine->fresh(), $coffee);

        $this->assertEquals(DispensingState::class, $vendingMachine->fresh()->state);
        $this->assertEquals('coffee', $vendingMachine->fresh()->selectedProduct->product->name);
    }

    public function test_product_selection_soda(): void
    {
        $vendingMachine = Machine::first();
        $service = new VendingService;
        $soda = Product::query()->where('name', 'soda')->first();

        $service->handleInsertCoin($vendingMachine, 2);

        $service->handleSelectProduct($vendingMachine->fresh(), $soda);

        $this->assertEquals(DispensingState::class, $vendingMachine->fresh()->state);
        $this->assertEquals('soda', $vendingMachine->fresh()->selectedProduct->product->name);
    }

    public function test_product_selection_soda_failed_balance(): void
    {
        $vendingMachine = Machine::first();
        $service = new VendingService;
        $soda = Product::query()->where('name', 'soda')->first();

        $service->handleInsertCoin($vendingMachine, 1);

        try {
            $service->handleSelectProduct($vendingMachine->fresh(), $soda);
        } catch (\Exception $e) {
            $this->assertEquals('Insufficient balance.', $e->getMessage());
        }

        $this->assertEquals(CoinInsertedState::class, $vendingMachine->fresh()->state);
    }

    public function test_product_selection_out_of_stock(): void
    {
        $vendingMachine = Machine::first();
        $service = new VendingService;
        $soda = Product::query()->where('name', 'soda')->first();
        $soda->stock = 0;

        $service->handleInsertCoin($vendingMachine, 1);

        try {
            $service->handleSelectProduct($vendingMachine->fresh(), $soda);
        } catch (\Exception $e) {
            $this->assertEquals('Product unavailable or out of stock.', $e->getMessage());
        }

        $this->assertEquals(CoinInsertedState::class, $vendingMachine->fresh()->state);
    }
}
