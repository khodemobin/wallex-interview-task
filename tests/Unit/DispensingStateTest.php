<?php

namespace Tests\Unit;

use App\Models\Machine;
use App\Models\Product;
use App\Services\VendingService;
use App\States\IdleState;
use Tests\TestCase;

class DispensingStateTest extends TestCase
{
    public function test_machine_dispense_product(): void
    {
        $vendingMachine = Machine::first();
        $service = new VendingService;
        $coffee = Product::query()->where('name', 'coffee')->first();
        $this->assertEquals(10, $coffee->stock);

        $service->handleInsertCoin($vendingMachine, 1);
        $service->handleSelectProduct($vendingMachine->fresh(), $coffee);
        $service->handleDispensing($vendingMachine->fresh());

        $this->assertEquals(0, $vendingMachine->fresh()->balance);
        $this->assertNull($vendingMachine->fresh()->selectedProduct);
        $this->assertEquals(9, $coffee->fresh()->stock);
        $this->assertEquals(IdleState::class, $vendingMachine->fresh()->state);
    }
}
