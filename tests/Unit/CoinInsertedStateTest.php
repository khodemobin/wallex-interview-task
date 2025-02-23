<?php

namespace Tests\Unit;

use App\Models\Machine;
use App\Services\VendingService;
use App\States\CoinInsertedState;
use Tests\TestCase;

class CoinInsertedStateTest extends TestCase
{
    public function test_change_state_and_balance_after_coin_inserted(): void
    {
        $vendingMachine = Machine::first();
        $this->assertEquals($vendingMachine->balance, 0);

        $service = new VendingService;

        $service->handleInsertCoin($vendingMachine, 1);

        $this->assertEquals($vendingMachine->fresh()->balance, 1);
        $this->assertEquals(CoinInsertedState::class, $vendingMachine->fresh()->state);
    }
}
