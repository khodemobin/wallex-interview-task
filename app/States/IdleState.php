<?php

namespace App\States;

use App\Interfaces\IMachineState;
use App\Interfaces\IVendingMachine;
use App\Models\Machine;

class IdleState implements IMachineState
{
    private Machine $machine;

    public function __construct(Machine $machine)
    {
        $this->machine = $machine;
    }

    public static function name(): string
    {
        return 'Idle';
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
