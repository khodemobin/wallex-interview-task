<?php

namespace App\States;

use App\Contracts\VendingMachineContext;
use App\Contracts\VendingMachineState;

class IdleState implements VendingMachineState
{
    private VendingMachineContext $machine;

    public function __construct(VendingMachineContext $machine)
    {
        $this->machine = $machine;
    }

    public function insertCoin(): string
    {
        $this->machine->setState(new CoinInsertedState($this->machine));

        return 'Coin inserted. Please select a product.';
    }

    public function selectProduct(string $product): string
    {
        return 'Please insert a coin first.';
    }

    public function dispense(): string
    {
        return 'No product to dispense.';
    }
}
