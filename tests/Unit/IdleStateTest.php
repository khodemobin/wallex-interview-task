<?php

namespace Tests\Unit;

use App\Models\Machine;
use App\Models\Product;
use App\Services\VendingService;
use App\States\IdleState;
use Tests\TestCase;

class IdleStateTest extends TestCase
{
    public function test_idle_state_initial(): void
    {
        $vendingMachine = Machine::first();
        $this->assertEquals(IdleState::class, $vendingMachine->state);
    }

    public function test_idle_state_after_dispense(): void
    {
        $vendingMachine = Machine::first();
        $service = new VendingService;

        $service->handleInsertCoin($vendingMachine, 1);
        $service->handleSelectProduct($vendingMachine->fresh(), Product::first());
        $service->handleDispensing($vendingMachine->fresh());
        $this->assertEquals(IdleState::class, $vendingMachine->fresh()->state);
    }
}
